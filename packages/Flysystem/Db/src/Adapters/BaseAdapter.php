<?php

namespace Aedart\Flysystem\Db\Adapters;

use Aedart\Contracts\Flysystem\Db\RecordTypes;
use Aedart\Contracts\Flysystem\Visibility;
use Aedart\Contracts\Streams\BufferSizes;
use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Contracts\Streams\FileStream as FileStreamInterface;
use Aedart\Contracts\Support\Helpers\Database\DbAware;
use Aedart\Flysystem\Db\Exceptions\ConnectionException;
use Aedart\Flysystem\Db\Exceptions\DatabaseAdapterException;
use Aedart\Streams\FileStream;
use Aedart\Support\Helpers\Database\DbTrait;
use Aedart\Utils\Json;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder;
use JsonException;
use League\Flysystem\Config;
use League\Flysystem\DirectoryAttributes;
use League\Flysystem\FileAttributes;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\PathPrefixer;
use League\Flysystem\StorageAttributes;
use League\Flysystem\UnableToCheckExistence;
use LogicException;
use stdClass;
use Throwable;

/**
 * @deprecated
 *
 * Base Adapter
 *
 * Abstraction for database adapters
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Flysystem\Db\Adapters
 */
abstract class BaseAdapter implements
    FilesystemAdapter,
    DbAware
{
    use DbTrait;

    /**
     * Path prefixer
     *
     * @var PathPrefixer
     */
    protected PathPrefixer $prefixer;

    /**
     * Name of "path" column in table
     *
     * @var string
     */
    protected string $pathColumn = 'path';

    /**
     * Name of "type" column in table
     *
     * @var string
     */
    protected string $typeColumn = 'type';

    /**
     * Creates a new adapter instance
     *
     * @param ConnectionInterface|null $connection [optional]
     */
    public function __construct(
        ConnectionInterface|null $connection = null
    )
    {
        $this
            ->setDb($connection)
            ->setPathPrefix('');
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
     * Set path prefix
     *
     * @param string $prefix
     *
     * @return self
     */
    public function setPathPrefix(string $prefix): static
    {
        return $this->setPrefixer(
            new PathPrefixer($prefix)
        );
    }

    /**
     * Set path prefixer instance
     *
     * When invoking this method,
     *
     * @param PathPrefixer $prefixer
     *
     * @return self
     */
    public function setPrefixer(PathPrefixer $prefixer): static
    {
        $this->prefixer = $prefixer;

        return $this;
    }

    /**
     * Get path prefixer instance
     *
     * @return PathPrefixer
     */
    public function getPrefixer(): PathPrefixer
    {
        return $this->prefixer;
    }

    /**
     * Applies path prefix for given path
     *
     * @see stripPrefix
     *
     * @param string $path
     *
     * @return string Prefixed path
     */
    public function applyPrefix(string $path): string
    {
        return $this->getPrefixer()->prefixPath($path);
    }

    /**
     * Strips path prefix from given path
     *
     * @see applyPrefix
     *
     * @param string $path
     *
     * @return string Path without prefix
     */
    public function stripPrefix(string $path): string
    {
        return $this->getPrefixer()->stripPrefix($path);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Fetch a directory record from given table that matches given path
     *
     * @param string $path
     * @param string $table
     * @param ConnectionInterface|null $connection [optional]
     * @param Config|null $config [optional]
     *
     * @return stdClass|null
     *
     * @throws UnableToCheckExistence
     */
    protected function fetchDirectory(
        string $path,
        string $table,
        ConnectionInterface|null $connection = null,
        Config|null $config = null
    ): stdClass|null
    {
        try {
            $connection = $connection ?? $this->connection();

            $result = $connection
                ->table($table)
                ->select()
                ->where($this->pathColumn, $this->applyPrefix($path))
                ->where($this->typeColumn, RecordTypes::DIRECTORY)
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
     * Fetch a file record from given table that matches given path
     *
     * @param string $path
     * @param string $table
     * @param ConnectionInterface|null $connection [optional]
     * @param Config|null $config [optional]
     *
     * @return stdClass|null
     *
     * @throws UnableToCheckExistence
     */
    protected function fetchFile(
        string $path,
        string $table,
        ConnectionInterface|null $connection = null,
        Config|null $config = null
    ): stdClass|null
    {
        try {
            $connection = $connection ?? $this->connection();

            $result = $connection
                ->table($table)
                ->select()
                ->where($this->pathColumn, $this->applyPrefix($path))
                ->where($this->typeColumn, RecordTypes::FILE)
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
     * Perform contents listing for given directory, using specified connection
     *
     * @param string $table
     * @param string $directory [optional]
     * @param bool $recursive [optional]
     * @param ConnectionInterface|null $connection [optional]
     *
     * @return iterable<StorageAttributes>
     */
    protected function performContentsListing(
        string $table,
        string $directory = '',
        bool $recursive = false,
        ?ConnectionInterface $connection = null
    ): iterable
    {
        try {
            $connection = $connection ?? $this->connection();

            $path = $this->applyPrefix($directory);

            // TODO: Future perspective; create custom iterator that can paginate
            // TODO: through results, so that very large "storage disks" can be handled!

            $result = $connection
                ->table($table)
                ->select()
                ->when(!empty($path), function (Builder $query) use ($path, $recursive) {
                    $query->when($recursive, function (Builder $q) use ($path) {
                        // When recursive
                        $q
                            ->where($this->pathColumn, '=', $path)
                            ->orWhere($this->pathColumn, 'LIKE', "{$path}%");
                    }, function (Builder $f) use ($path) {
                        // When not recursive
                        $f->where($this->pathColumn, '=', $path);

                        // TODO: Not sure that files are included in via the query.
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
     * Normalise given record
     *
     * Method converts the given database record into a "file" or "directory"
     * attribute instance.
     *
     * @see RecordTypes::FILE
     * @see RecordTypes::DIRECTORY
     *
     * @param stdClass $record
     *
     * @return StorageAttributes
     *
     * @throws LogicException If record "type" is missing or unknown
     * @throws JsonException If record's extra meta data cannot be decoded
     */
    protected function normaliseRecord(stdClass $record): StorageAttributes
    {
        // Convert to array.
        $record = get_object_vars($record);

        if (!isset($record[$this->typeColumn])) {
            throw new LogicException('Record is missing "type" property');
        }

        return match($record[$this->typeColumn]) {
            RecordTypes::FILE => $this->makeFileAttribute($record),
            RecordTypes::DIRECTORY => $this->makeDirectoryAttribute($record),
            default => throw new LogicException(sprintf('Unable to normalise record of type %s. Allowed types: %s',
                $record[$this->typeColumn],
                implode(', ', RecordTypes::ALLOWED)
            ))
        };
    }

    /**
     * Creates a new file attribute, for given file record
     *
     * @param array $record
     *
     * @return StorageAttributes
     *
     * @throws JsonException
     */
    protected function makeFileAttribute(array $record): StorageAttributes
    {
        return FileAttributes::fromArray([
            StorageAttributes::ATTRIBUTE_PATH => $this->stripPrefix($record[$this->pathColumn]),
            StorageAttributes::ATTRIBUTE_FILE_SIZE => (int) $record['file_size'],
            StorageAttributes::ATTRIBUTE_VISIBILITY => $record['visibility'],
            StorageAttributes::ATTRIBUTE_LAST_MODIFIED => (int) $record['last_modified'],
            StorageAttributes::ATTRIBUTE_MIME_TYPE => $record['mime_type'],
            StorageAttributes::ATTRIBUTE_EXTRA_METADATA => $this->decodeExtraMetaData($record['extra_metadata']),
        ]);
    }

    /**
     * Creates a new directory attribute, for given directory record
     *
     * @param array $record
     *
     * @return StorageAttributes
     *
     * @throws JsonException
     */
    protected function makeDirectoryAttribute(array $record): StorageAttributes
    {
        return DirectoryAttributes::fromArray([
            StorageAttributes::ATTRIBUTE_TYPE => $record[$this->typeColumn],
            StorageAttributes::ATTRIBUTE_PATH => $this->stripPrefix($record[$this->pathColumn]),
            StorageAttributes::ATTRIBUTE_VISIBILITY => $record['visibility'],
            StorageAttributes::ATTRIBUTE_LAST_MODIFIED => (int) $record['last_modified'],
            StorageAttributes::ATTRIBUTE_EXTRA_METADATA => $this->decodeExtraMetaData($record['extra_metadata']),
        ]);
    }

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
            throw new DatabaseAdapterException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Resolves directory visibility, when writing to table record
     *
     * @param Config $config
     *
     * @return string
     */
    protected function resolveDirectoryVisibility(Config $config): string
    {
        return $config->get(
            Config::OPTION_VISIBILITY,
            $config->get(Config::OPTION_DIRECTORY_VISIBILITY, Visibility::PRIVATE)
        );
    }

    /**
     * Resolves timestamp, when writing to table record
     *
     * If "timestamp" is set in given configuration, then it will be returned.
     * Otherwise, current unix timestamp is returned.
     *
     * @param Config $config
     *
     * @return int
     */
    protected function resolveLastModifiedTimestamp(Config $config): int
    {
        return $config->get('timestamp', time());
    }

    /**
     * Resolves extra meta data from configuration
     *
     * @param Config $config
     *
     * @return string|null Json encoded string or null if no extra meta data
     *
     * @throws JsonException
     */
    protected function resolveExtraMetaData(Config $config): string|null
    {
        $extra = $config->get('extra_meta_data', null);
        if (!isset($extra)) {
            return null;
        }

        return Json::encode($extra);
    }

    /**
     * Decode extra meta data from database table
     *
     * @param string|null $data
     *
     * @return array|null
     *
     * @throws JsonException
     */
    protected function decodeExtraMetaData(string|null $data): array|null
    {
        if (!isset($data)) {
            return null;
        }

        return Json::decode($data, true);
    }

    /**
     * Creates a new file stream instance
     *
     * @return FileStreamInterface
     *
     * @throws StreamException
     */
    protected function makeStream(): FileStreamInterface
    {
        return FileStream::openMemory('r+b');
    }
}