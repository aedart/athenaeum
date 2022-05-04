<?php

namespace Aedart\Flysystem\Db\Adapters;

use Aedart\Contracts\Flysystem\Db\RecordTypes;
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
        // TODO: Implement fileExists() method.
    }

    /**
     * @inheritDoc
     */
    public function directoryExists(string $path): bool
    {
        $dir = $this->fetchDirectory($path);

        return isset($dir);
    }

    /**
     * @inheritDoc
     */
    public function write(string $path, string $contents, Config $config): void
    {
        // TODO: Implement write() method.
    }

    /**
     * @inheritDoc
     */
    public function writeStream(string $path, $contents, Config $config): void
    {
        // TODO: Implement writeStream() method.
    }

    /**
     * @inheritDoc
     */
    public function read(string $path): string
    {
        // TODO: Implement read() method.
    }

    /**
     * @inheritDoc
     */
    public function readStream(string $path)
    {
        // TODO: Implement readStream() method.
    }

    /**
     * @inheritDoc
     */
    public function delete(string $path): void
    {
        // TODO: Implement delete() method.
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
        // TODO: Implement setVisibility() method.
    }

    /**
     * @inheritDoc
     */
    public function visibility(string $path): FileAttributes
    {
        // TODO: Implement visibility() method.
    }

    /**
     * @inheritDoc
     */
    public function mimeType(string $path): FileAttributes
    {
        // TODO: Implement mimeType() method.
    }

    /**
     * @inheritDoc
     */
    public function lastModified(string $path): FileAttributes
    {
        // TODO: Implement lastModified() method.
    }

    /**
     * @inheritDoc
     */
    public function fileSize(string $path): FileAttributes
    {
        // TODO: Implement fileSize() method.
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
        // TODO: Implement move() method.
    }

    /**
     * @inheritDoc
     */
    public function copy(string $source, string $destination, Config $config): void
    {
        // TODO: Implement copy() method.
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
     * references.
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

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Execute callback within a transaction.
     *
     * @param callable $callback
     *
     * @return mixed
     *
     * @throws DatabaseAdapterException
     */
    protected function transaction(callable $callback): mixed
    {
        try {
            return $this->connection()->transaction($callback);
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
     * Fetch a directory record from given table that matches given path
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
                $fileHashes[] = $record['content_hash'];
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

        // Mass-decrement reference counters in file contents records.
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

            // TODO: Future perspective; create custom iterator that can paginate
            // TODO: through results, so that very large "storage disks" can be handled!

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