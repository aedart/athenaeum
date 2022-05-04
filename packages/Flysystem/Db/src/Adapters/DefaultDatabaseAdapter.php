<?php

namespace Aedart\Flysystem\Db\Adapters;

use Aedart\Contracts\Flysystem\Db\RecordTypes;
use Aedart\Streams\FileStream;
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
use RuntimeException;
use Throwable;

/**
 * @deprecated 
 *
 * Default Database Adapter
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Flysystem\Db\Adapters
 */
class DefaultDatabaseAdapter extends BaseAdapter
{
    /**
     * {@inheritDoc}
     *
     * @param string $table Name of table where files are located
     */
    public function __construct(
        protected string $table,
        ConnectionInterface|null $connection = null
    )
    {
        parent::__construct($connection);
    }

    /*****************************************************************
     * Filesystem Adapter methods
     ****************************************************************/

    /**
     * @inheritDoc
     */
    public function fileExists(string $path): bool
    {
        $file = $this->fetchFile($path, $this->table);

        return isset($file);
    }

    /**
     * @inheritDoc
     */
    public function directoryExists(string $path): bool
    {
        $dir = $this->fetchDirectory($path, $this->table);

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
        $resource = $this->readStream($path);

        $contents = stream_get_contents($resource);
        @fclose($resource);

        return $contents;
    }

    /**
     * @inheritDoc
     */
    public function readStream(string $path)
    {
        try {
            $file = $this->fetchFile($path, $this->table);
            if (!isset($file)) {
                throw new RuntimeException('File does not exist');
            }

            $contents = $file->contents;
            if (is_resource($contents)) {
                return $contents;
            }

            return $this
                ->makeStream()
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
        try {
            $connection = $config->get('connection', $this->connection());

            $path = $this->applyPrefix($path);
            $visibility = $this->resolveDirectoryVisibility($config);
            $timestamp = $this->resolveLastModifiedTimestamp($config);
            $extra = $this->resolveExtraMetaData($config);

            // TODO: PROBLEM: We need to create directories recursively. A single entry is NOT good
            // TODO: enough -> see listContents()'s implementation for details.

            // Flysystem does not state anything about recursively creation of directories.
            // We assume that a single entry is sufficient...
            $result = $connection
                ->table($this->table)
                ->updateOrInsert(
                    // Where matches
                    [
                        'type' => RecordTypes::DIRECTORY,
                        'path' => $path,
                        'visibility' => $visibility,
                        'last_modified' => $timestamp,
                        'extra_metadata' => $extra
                    ],

                    // Values to be updated, if it exists.
                    // Otherwise, both arrays are merged and inserted!
                    [
                        'path' => $path,
                        'visibility' => $visibility,
                        'last_modified' => $timestamp,
                        'extra_metadata' => $extra
                    ]
                );

            if (!$result) {
                throw new RuntimeException(sprintf('directory was not created in table: %s', $this->table));
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
        yield from $this->performContentsListing($this->table, $path, $deep);
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

    /*****************************************************************
     * Configuration methods
     ****************************************************************/

    /*****************************************************************
     * Internals
     ****************************************************************/
}