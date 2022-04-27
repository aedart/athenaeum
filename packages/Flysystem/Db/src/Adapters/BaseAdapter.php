<?php

namespace Aedart\Flysystem\Db\Adapters;

use Aedart\Contracts\Support\Helpers\Database\DbAware;
use Aedart\Flysystem\Db\Exceptions\ConnectionException;
use Aedart\Support\Helpers\Database\DbTrait;
use Illuminate\Database\ConnectionInterface;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\PathPrefixer;
use Packages\Filesystem\Flysystem\Adapters\Exceptions\UnableToResolveDatabaseConnection;

/**
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
     * Creates a new adapter instance
     *
     * @param ConnectionInterface|null $connection [optional]
     */
    public function __construct(
        ConnectionInterface|null $connection = null
    )
    {
        $this->setDb($connection);
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
}