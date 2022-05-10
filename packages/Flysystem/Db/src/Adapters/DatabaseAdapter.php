<?php

namespace Aedart\Flysystem\Db\Adapters;

use Aedart\Contracts\Flysystem\Db\RecordTypes;
use Aedart\Contracts\Flysystem\Visibility;
use Aedart\Contracts\MimeTypes\Exceptions\MimeTypeDetectionException;
use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Contracts\Streams\FileStream;
use Aedart\Contracts\Support\Helpers\Database\DbAware;
use Aedart\Flysystem\Db\Adapters\Concerns;
use Aedart\Flysystem\Db\Exceptions\ConnectionException;
use Aedart\Flysystem\Db\Exceptions\DatabaseAdapterException;
use Aedart\Support\Helpers\Database\DbTrait;
use Aedart\Utils\Str;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder;
use League\Flysystem\Config;
use League\Flysystem\FileAttributes;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\FilesystemException;
use League\Flysystem\InvalidVisibilityProvided;
use League\Flysystem\StorageAttributes;
use League\Flysystem\UnableToCheckExistence;
use League\Flysystem\UnableToCopyFile;
use League\Flysystem\UnableToCreateDirectory;
use League\Flysystem\UnableToDeleteDirectory;
use League\Flysystem\UnableToDeleteFile;
use League\Flysystem\UnableToMoveFile;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToRetrieveMetadata;
use League\Flysystem\UnableToSetVisibility;
use League\Flysystem\UnableToWriteFile;
use RuntimeException;
use stdClass;
use Throwable;

/**
 * Database Adapter
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Flysystem\Db\Adapters
 */
class DatabaseAdapter implements FilesystemAdapter,
    DbAware
{
    use Concerns\ExtraMetaData;
    use Concerns\Hashing;
    use Concerns\MimeTypes;
    use Concerns\PathPrefixing;
    use Concerns\StorageAttributes;
    use Concerns\Streams;
    use Concerns\Timestamps;
    use Concerns\Visibility;
    use DbTrait;

    /**
     * Creates a new database adapter instance
     *
     * @param string $filesTable
     * @param string $contentsTable
     * @param ConnectionInterface|null $connection [optional]
     */
    public function __construct(
        protected string $filesTable,
        protected string $contentsTable,
        ConnectionInterface|null $connection = null,
    )
    {
        $this
            ->setDb($connection)
            ->setPathPrefix('');
    }

    /**
     * @inheritDoc
     */
    public function fileExists(string $path): bool
    {
        $file = $this->fetchFile($path, false);

        return isset($file);
    }

    /**
     * @inheritDoc
     */
    public function directoryExists(string $path): bool
    {
        $directory = $this->fetchDirectory($path);

        return isset($directory);
    }

    /**
     * @inheritDoc
     */
    public function write(string $path, string $contents, Config $config): void
    {
        try {
            $stream = $this
                ->openTemporaryStream(
                    $this->resolveMaxMemory($config)
                )
                ->put($contents);

            $this->writeStream($path, $stream->detach(), $config);
        } catch (Throwable $e) {
            throw UnableToWriteFile::atLocation($path, $e->getMessage(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function writeStream(string $path, $contents, Config $config): void
    {
        try {
            // Ensure directory is created for given file path.
            $this->createDirectory(dirname($path), $config);

            $this->transaction(function(ConnectionInterface $connection) use($path, $contents, $config) {
                // Set connection in config, so that it can be passed further.
                $config = $config->extend([ 'connection' => $connection ]);

                // Wrap resource into stream and rewind. This will automatically
                // fail if stream is not seekable.
                $stream = $this
                    ->openStreamFrom($contents)
                    ->positionToStart();

                // Prepare file record...
                $record = $this->prepareFileRecord($path, $stream, $config);

                // Obtain eventual existing file's meta information. This will be needed to
                // resolve content record's `reference count`.
                $original = $this->fetchFile($path, false, $config);

                // Add content hash to config, so that re-hashing is avoided.
                $config = $config->extend([
                    'hash' => $config->get('hash', $record['content_hash'])
                ]);

                // Update existing file record and its contents
                if (isset($original)) {

                    $wasUpdated = (bool) $connection
                        ->table($this->filesTable)
                        ->where('path', $record['path'])
                        ->where('type', RecordTypes::FILE)
                        ->limit(1)
                        ->update($record);

                    if (!$wasUpdated) {
                        throw new RuntimeException(sprintf('Existing file (%s) was not updated in database. Please check database connection and permissions', $path));
                    }

                    // If the original record's content hash does not match the content hash, then previous
                    // content record's reference count MUST be decreased and a cleaned up.
                    if ($record['content_hash'] !== $original->content_hash) {
                        $this->decrementReferenceCount($original->content_hash, $config);
                        $this->cleanupFileContents();

                        // Also, write the changed file contents...
                        $this->writeFileContentRecord($path, $stream, $config);
                    }

                    // Otherwise, the file's content was not changed - We can skip any further processing
                    return;
                }

                // Otherwise, we insert a new file record
                $wasCreated = $connection
                    ->table($this->filesTable)
                    ->insert($record);

                if (!$wasCreated) {
                    throw new RuntimeException(sprintf('File (%s) was not inserted in database. Please check database connection and permissions', $path));
                }

                // Finally, write file's contents.
                $this->writeFileContentRecord($path, $stream, $config);
            });

        } catch (Throwable $e) {
            throw UnableToWriteFile::atLocation($path, $e->getMessage(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function read(string $path): string
    {
        try {
            $resource = $this->readStream($path);

            $content = stream_get_contents($resource);
            if ($content === false) {
                throw new RuntimeException('Unable to read file contents');
            }

            $wasClosed = fclose($resource);
            if (!$wasClosed) {
                throw new RuntimeException('Failed to close file contents stream.');
            }

            return $content;
        } catch (Throwable $e) {
            throw UnableToReadFile::fromLocation($path, $e->getMessage(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function readStream(string $path)
    {
        try {
            $file = $this->fetchFile($path, true);
            if (!isset($file)) {
                throw new RuntimeException('File does not exist');
            }

            // Depending on database and PDO driver, contents could be a resource
            // or a string. In any case, we need to respect Flysystem's interface
            // and return a resource.
            $contents = $file->contents ?? '';
            if (is_resource($contents)) {
                return $contents;
            }

            return $this
                ->openMemoryStream()
                ->put($contents)
                ->positionToStart()
                ->detach();

        } catch (Throwable $e) {
            throw UnableToReadFile::fromLocation($path, $e->getMessage(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(string $path): void
    {
        if (!$this->fileExists($path)) {
            return;
        }

        try {

            $this->transaction(function(ConnectionInterface $connection) use($path) {

                // Create new configuration to pass connection into on...
                $config = new Config([
                    'connection' => $connection
                ]);

                // Obtain existing file record, so that we can use it the "content hash"
                // to identify the contents record and decrease reference count.
                $record = $this->fetchFile($path, false, $config);

                // Remove file record
                $removed = $connection
                    ->table($this->filesTable)
                    ->where('type', RecordTypes::FILE)
                    ->where('path', $path)
                    ->delete();

                if ($removed === 0) {
                    throw new RuntimeException('File record was not removed from database');
                }

                // Decrement reference count for file contents and cleanup...
                $this->decrementReferenceCount($record->content_hash, $config);
                $this->cleanupFileContents($config);
            });

        } catch (Throwable $e) {
            throw UnableToDeleteFile::atLocation($path, $e->getMessage(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function deleteDirectory(string $path): void
    {
        try {
            $this->transaction(function(ConnectionInterface $connection) use($path) {

                $this->deleteDirectoryContents($path, new Config([
                    'connection' => $connection
                ]));

                // Remove the requested directory itself
                $connection
                    ->table($this->filesTable)
                    ->where('path', $this->applyPrefix($path))
                    ->where('type', RecordTypes::DIRECTORY)
                    ->limit(1)
                    ->delete();
            });
        } catch (Throwable $e) {
            throw UnableToDeleteDirectory::atLocation($path, $e->getMessage(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function createDirectory(string $path, Config $config): void
    {
        // Skip creating if path is root directory (empty)
        if (empty($path) || $path === '.') {
            return;
        }

        try {
            $connection = $this->resolveConnection($config);

            $path = $this->applyPrefix($path);
            $visibility = $this->resolveDirectoryVisibility($config);
            $timestamp = $this->resolveLastModifiedTimestamp($config);
            $extra = $this->resolveExtraMetaData($config);

            // Although not very clearly documented, Flysystem expects directories to
            // be created recursively. Therefore, based on the given path one or more
            // directories must be created.

            // Create tree structure based on given directory path.
            $directories = Str::tree($path, '/');

            // Prepare directory records (the tree structure)
            $records = [];
            foreach ($directories as $directory) {
                $records[] = [
                    'type' => RecordTypes::DIRECTORY,
                    'path' => $directory,
                    'level' => $this->directoryLevel($directory),
                    'visibility' => $visibility,
                    'last_modified' => $timestamp,
                    'extra_metadata' => $extra
                ];
            }

            // Upsert directories - create them if they do not exist,
            // or update them, if already created.
            $result = $connection
                ->table($this->filesTable)
                ->upsert(
                    values: $records,
                    uniqueBy: [ 'path' ],
                    update: [
                        'level',
                        'visibility',
                        'last_modified',
                        'extra_metadata'
                    ]
                );

            if (!$result) {
                throw new RuntimeException(sprintf('Directory was not created in table: %s', $this->filesTable));
            }

        } catch (Throwable $e) {
            throw UnableToCreateDirectory::dueToFailure($path, $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function setVisibility(string $path, string $visibility): void
    {
        if (!in_array($visibility, Visibility::ALLOWED)) {
            throw InvalidVisibilityProvided::withVisibility($visibility, implode('or ', Visibility::ALLOWED));
        }

        try {
            $path = $this->applyPrefix($path);

            $affected = $this
                ->resolveConnection()
                ->table($this->filesTable)
                ->where('path', $path)
                ->limit(1)
                ->update([ 'visibility' => $visibility ]);

            if ($affected === 0) {
                throw new RuntimeException(sprintf('Visibility was not changed. Unable to find file or directory: %s', $path));
            }

        } catch (Throwable $e) {
            throw UnableToSetVisibility::atLocation($path, $e->getMessage(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function visibility(string $path): FileAttributes
    {
        try {
            return $this->getFileMeta($path);
        } catch (Throwable $e) {
            throw UnableToRetrieveMetadata::visibility($path, $e->getMessage(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function mimeType(string $path): FileAttributes
    {
        try {
            return $this->getFileMeta($path);
        } catch (Throwable $e) {
            throw UnableToRetrieveMetadata::mimeType($path, $e->getMessage(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function lastModified(string $path): FileAttributes
    {
        try {
            return $this->getFileMeta($path);
        } catch (Throwable $e) {
            throw UnableToRetrieveMetadata::lastModified($path, $e->getMessage(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function fileSize(string $path): FileAttributes
    {
        try {
            return $this->getFileMeta($path);
        } catch (Throwable $e) {
            throw UnableToRetrieveMetadata::fileSize($path, $e->getMessage(), $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function listContents(string $path, bool $deep): iterable
    {
        return $this->performContentsListing($path, $deep);
    }

    /**
     * @inheritDoc
     */
    public function move(string $source, string $destination, Config $config): void
    {
        try {
            // Copy the file
            $this->performCopy($source, $destination, $config);

            // Remove file at source location
            $this->delete($source);
        } catch (Throwable $e) {
            throw UnableToMoveFile::fromLocationTo($source, $destination, $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function copy(string $source, string $destination, Config $config): void
    {
        try {
            $this->performCopy($source, $destination, $config);
        } catch (Throwable $e) {
            throw UnableToCopyFile::fromLocationTo($source, $destination, $e);
        }
    }

    /**
     * Get the established database connection
     *
     * @return ConnectionInterface
     *
     * @throws ConnectionException
     */
    public function connection(): ConnectionInterface
    {
        $connection = $this->getDb();
        if (!isset($connection)) {
            throw new ConnectionException('Database connection could not be resolved. Please check your configuration.');
        }

        return $connection;
    }

    /**
     * Cleanup file contents
     *
     * Method deletes all file contents records that have 0 or fewer
     * in their `reference_count`.
     *
     * @param Config|null $config [optional]
     *
     * @return int Affected rows
     */
    public function cleanupFileContents(Config|null $config = null): int
    {
        $connection = $this->resolveConnection($config);

        return $connection
            ->table($this->contentsTable)
            ->where('reference_count', '<=', 0)
            ->delete();
    }

    /**
     * Retrieve meta information about given file
     *
     * @param string $path
     *
     * @return FileAttributes
     *
     * @throws UnableToReadFile
     * @throws \LogicException If record "type" is missing or unknown
     * @throws \JsonException If record's extra meta data cannot be decoded
     */
    public function getFileMeta(string $path): FileAttributes
    {
        $record = $this->fetchFile($path, false);

        if (!isset($record)) {
            throw UnableToReadFile::fromLocation($path, 'File does not exist');
        }

        /** @var FileAttributes $normalised */
        $normalised = $this->normaliseRecord($record);
        return $normalised;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Execute callback within a transaction.
     *
     * @param callable $callback
     * @param Config|null $config [optional]
     *
     * @return mixed
     *
     * @throws DatabaseAdapterException
     */
    protected function transaction(callable $callback, Config|null $config = null): mixed
    {
        try {
            $connection = $this->resolveConnection($config);

            return $connection->transaction($callback);
        } catch (Throwable $e) {
            $code = $e->getCode();
            if (!is_int($code)) {
                $code = 0;
            }

            throw new DatabaseAdapterException($e->getMessage(), $code, $e);
        }
    }

    /**
     * Resolve database connection
     *
     * If "connection" is set in given configuration, then it will be returned.
     * Otherwise, the adapter's default connection is returned.
     *
     * @param Config|null $config [optional]
     *
     * @return ConnectionInterface
     */
    protected function resolveConnection(Config|null $config = null): ConnectionInterface
    {
        if (!isset($config)) {
            return $this->connection();
        }

        return $config->get('connection', $this->connection());
    }

    /**
     * Fetch a directory record that matches given path
     *
     * @param string $path
     * @param Config|null $config [optional]
     *
     * @return stdClass|null
     *
     * @throws UnableToCheckExistence
     */
    protected function fetchDirectory(string $path, Config|null $config = null): stdClass|null
    {
        try {
            $connection = $this->resolveConnection($config);

            $result = $connection
                ->table($this->filesTable)
                ->select()
                ->where('path', $this->applyPrefix($path))
                ->where('type', RecordTypes::DIRECTORY)
                ->limit(1)
                ->get();

            if ($result->isEmpty()) {
                return null;
            }

            return $result->first();
        } catch (Throwable $e) {
            throw UnableToCheckExistence::forLocation($path, $e);
        }
    }

    /**
     * Fetch a file record that matches given path
     *
     * @param string $path
     * @param bool $withContents [optional] When true, then file's content is included in output.
     * @param Config|null $config [optional]
     *
     * @return stdClass|null
     */
    protected function fetchFile(string $path, bool $withContents = true, Config|null $config = null): stdClass|null
    {
        try {
            $connection = $this->resolveConnection($config);

            $files = $this->filesTable;
            $contents = $this->contentsTable;

            $result = $connection
                ->table($files)
                ->select()

                // Join with contents table, if requested
                ->when($withContents, function (Builder $query) use ($files, $contents) {
                    // TODO: Select / Bind PDO::PARAM_LOB for file content, when requested.
                    // TODO: @see https://www.php.net/manual/en/pdo.lobs.php

                    $query->join($contents, "{$files}.content_hash", '=', "{$contents}.hash");
                })

                ->where("{$files}.path", $this->applyPrefix($path))
                ->where('type', RecordTypes::FILE)
                ->limit(1)
                ->get();

            if ($result->isEmpty()) {
                return null;
            }

            return $result->first();
        } catch (Throwable $e) {
            throw UnableToCheckExistence::forLocation($path, $e);
        }
    }

    /**
     * Delete all contents of given directory - nested directories and files
     *
     * @param string $path
     * @param Config|null $config [optional]
     *
     * @return int Affected rows
     */
    protected function deleteDirectoryContents(string $path, Config|null $config = null): int
    {
        // List contents of directory
        $list = $this->performContentsListing($path, true, $config);

        // Abort if directory is empty
        if (empty($list)) {
            return 0;
        }

        // Process each record and save a reference to its path. When a file is
        // encountered, then its contents hash is also saved. This will be
        // needed for decrementing reference counts.
        $root = $this->applyPrefix($path);
        $recordPaths = [];
        $fileHashes = [];
        foreach ($list as $record) {
            // Skip to next, if record matches requested directory
            if ($record['path'] === $root) {
                continue;
            }

            $recordPaths[] = $record['path'];

            if ($record['type'] === RecordTypes::FILE) {
                $fileHashes[] = $record->extraMetadata()['hash'];
            }
        }

        // Deleted all nested files and directories.
        $connection = $this->resolveConnection($config);
        $affected = $connection
            ->table($this->filesTable)
            ->whereIn('path', $recordPaths)
            ->limit(count($recordPaths))
            ->delete();

        if ($affected === 0) {
            return 0;
        }

        // Mass-decrement "reference count" in file content records.
        $connection
            ->table($this->contentsTable)
            ->whereIn('hash', $fileHashes)
            ->limit(count($fileHashes))
            ->decrement('reference_count');

        // Finally, run cleanup
        $this->cleanupFileContents($config);

        return $affected;
    }

    /**
     * Perform contents listing for given directory, using specified connection
     *
     * @param string $directory [optional]
     * @param bool $deep [optional]
     * @param Config|null $config [optional]
     *
     * @return iterable<StorageAttributes>
     */
    protected function performContentsListing(
        string $directory = '',
        bool $deep = false,
        Config|null $config = null
    ): iterable
    {
        try {
            $connection = $this->resolveConnection($config);

            $path = $this->applyPrefix($directory);

            // FUTURE PERSPECTIVE: Create a custom iterator that automatically paginates
            // through available results, to better support "large disks".

            $result = $connection
                ->table($this->filesTable)
                ->select()
                ->when(!empty($path), function(Builder $query) use($path, $deep) {
                    $query->where(function(Builder $query) use($path) {
                        $query
                            ->where('path', '=', $path)
                            ->orWhere('path', 'LIKE', "{$path}%");
                    })

                    // When deep listing requested
                    ->when($deep, function(Builder $query) use($path) {
                        $query->where('level', '>=', $this->directoryLevel($path) + 1);
                    }, function(Builder $query) use($path) {
                        // Otherwise...
                        $query->where('level', $this->directoryLevel($path) + 1);
                    });

                }, function(Builder $query) use($deep) {
                    $query->when(!$deep, function(Builder $query) {
                        // When no directory is requested ~ root level, ensure that we only list
                        // those placed at level 0 when "deep" isn't requested
                        $query->where('level', 0);
                    });
                })
                ->orderBy('path', 'asc')
                ->get();

            if ($result->isEmpty()) {
                return [];
            }

            $records = $result->getIterator();
            foreach ($records as $record){
                yield $this->normaliseRecord($record);
            }
        } catch (Throwable $e) {
            throw new DatabaseAdapterException(sprintf('Contents listing failed for: %s', $directory), $e->getCode(), $e);
        }
    }

    /**
     * Copies the source file inti given destination
     *
     * Note: If the file already exists at the destination, then it will be
     * overwritten!
     *
     * @param string $source
     * @param string $destination
     * @param Config $config
     *
     * @return void
     *
     * @throws FilesystemException
     */
    protected function performCopy(string $source, string $destination, Config $config): void
    {
        $record = $this->fetchFile($source, true, $config);
        if(!isset($record)) {
            throw UnableToReadFile::fromLocation($source, 'File does not exist');
        }

        // Write a new file on given destination. NOTE: If the file already exists,
        // then this will overwrite it - in accordance with Flysystem's API description:
        // @see https://flysystem.thephpleague.com/docs/usage/filesystem-api/#moving-and-copying
        $contents = $record->contents;

        // Resolve visibility, MIME-Type and extra meta-data of copied file...
        $config = $config->extend([
            Config::OPTION_VISIBILITY => $config->get(Config::OPTION_VISIBILITY, $record->visibility ?? null),
            'mime_type' => $config->get('mime_type', $record->mime_type ?? null),
            'extra_metadata' => $config->get('extra_metadata', $record->extra_metadata ?? null),
        ]);

        if (is_resource($contents)) {
            $this->writeStream($destination, $contents, $config);

            fclose($contents);
        } else {
            $this->write($destination, $contents, $config);
        }
    }

    /**
     * Write file contents record
     *
     * @param string $path
     * @param $stream
     * @param Config $config
     *
     * @return array
     *
     * @throws StreamException
     */
    protected function writeFileContentRecord(string $path, $stream, Config $config): array
    {
        // Prepare the file contents record
        $record = $this->prepareContentsRecord($path, $stream, $config);

        // Create new file content record or update existing. When a file content already exists,
        // then its "reference count" is simply increased with +1. The "content hash" is used as
        // unique identifier to determine if file content already exists or not (deduplication).
        // @see https://en.wikipedia.org/wiki/Data_deduplication
        $affected = $this
            ->resolveConnection($config)
            ->table($this->contentsTable)
            ->upsert(
                values: [ $record ],
                uniqueBy: [ 'hash' ],
                update: [ 'reference_count' => $this->makeIncrementExpression(1, $config) ]
            );

        if ($affected === 0) {
            return [];
        }

        // Unset the "reference count" property because it will most likely not
        // be correct. A database query is required to obtain the resulting value.
        unset($record['reference_count']);

        // Finally, return record
        return $record;
    }

    /**
     * Prepares a new "file" record to be inserted into database table
     *
     * @param string $path
     * @param FileStream $stream
     * @param Config $config
     * @return array
     *
     * @throws MimeTypeDetectionException
     * @throws StreamException
     * @throws \JsonException
     */
    protected function prepareFileRecord(string $path, FileStream $stream, Config $config): array
    {
        return [
            'type' => RecordTypes::FILE,
            'path' => $this->applyPrefix($path),
            'level' => $this->directoryLevel($path),
            'file_size' => $stream->getSize(),
            'mime_type' => $this->resolveMimeType($stream, $config),
            'visibility' => $this->resolveFileVisibility($config),
            'content_hash' => $this->resolveContentHash($stream, $config),
            'last_modified' => $this->resolveLastModifiedTimestamp($config),
            'extra_metadata' => $this->resolveExtraMetaData($config)
        ];
    }

    /**
     * Prepares a new "file contents" record to be inserted into database table
     *
     * @param string $path
     * @param FileStream $stream
     * @param Config $config
     *
     * @return array
     *
     * @throws StreamException
     */
    protected function prepareContentsRecord(string $path, FileStream $stream, Config $config): array
    {
        // Note: path is not used here, but it is kept to allow eventual customisation / extended
        // versions of this adapter!

        return [
            'hash' => $this->resolveContentHash($stream, $config),

            // Initial reference count. This is ONLY valid when inserting a new
            // record. It must be updated when existing record is updated.
            'reference_count' => 1,

            // Database driver should automatically deal with "resource".
            // Alternatively, the resource should be converted to a string, but
            // that COULD increase memory consumption a lot (depending on filesize).
            'contents' => $stream
                ->positionToStart()
                ->resource()
        ];
    }

    /**
     * Returns a new "increment reference count" query expression
     *
     * @param int $amount [optional]
     * @param Config|null $config [optional]
     *
     * @return mixed
     */
    protected function makeIncrementExpression(int $amount = 1, Config|null $config = null): mixed
    {
        $config = $config ?? new Config();
        $connection = $this->resolveConnection($config);

        $table = $this->contentsTable;
        $query = $connection
            ->table($table);

        $wrapped = $query
            ->getGrammar()
            ->wrap("{$table}.reference_count");

        return $query->raw("{$wrapped} + {$amount}");
    }

    /**
     * Decrement reference count in file contents record
     *
     * @param string $hash
     * @param Config|null $config [optional]
     *
     * @return int Affected rows
     */
    protected function decrementReferenceCount(string $hash, Config|null $config = null): int
    {
        $connection = $this->resolveConnection($config);

        return $connection
            ->table($this->contentsTable)
            ->where('hash', $hash)
            ->limit(1)
            ->decrement('reference_count');
    }

    /**
     * Returns the directory level for given path
     *
     * Note: this method does NOT apply path-prefixing on
     * given path!
     *
     * @param string $path
     *
     * @return int
     */
    protected function directoryLevel(string $path): int
    {
        return substr_count($path, '/');
    }
}