<?php

namespace Aedart\Flysystem\Db\Adapters;

use Aedart\Contracts\Support\Helpers\Database\DbAware;
use Aedart\Flysystem\Db\Adapters\Concerns;
use Aedart\Flysystem\Db\Exceptions\ConnectionException;
use Aedart\Flysystem\Db\Exceptions\DatabaseAdapterException;
use Aedart\Support\Helpers\Database\DbTrait;
use Illuminate\Database\ConnectionInterface;
use League\Flysystem\Config;
use League\Flysystem\FileAttributes;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\FilesystemException;
use League\Flysystem\InvalidVisibilityProvided;
use League\Flysystem\UnableToCheckExistence;
use League\Flysystem\UnableToCopyFile;
use League\Flysystem\UnableToCreateDirectory;
use League\Flysystem\UnableToDeleteDirectory;
use League\Flysystem\UnableToDeleteFile;
use League\Flysystem\UnableToMoveFile;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToRetrieveMetadata;
use League\Flysystem\UnableToWriteFile;
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
        // TODO: Implement directoryExists() method.
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
        // TODO: Implement deleteDirectory() method.
    }

    /**
     * @inheritDoc
     */
    public function createDirectory(string $path, Config $config): void
    {
        // TODO: Implement createDirectory() method.
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
        // TODO: Implement listContents() method.
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
            throw new DatabaseAdapterException($e->getMessage(), $e->getCode(), $e);
        }
    }
}