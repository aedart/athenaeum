<?php

namespace Aedart\Flysystem\Db\Adapters;

use Aedart\Contracts\Flysystem\Db\RecordTypes;
use Aedart\Contracts\Flysystem\Visibility;
use Aedart\Contracts\Support\Helpers\Database\DbAware;
use Aedart\Flysystem\Db\Exceptions\ConnectionException;
use Aedart\Flysystem\Db\Exceptions\DatabaseAdapterException;
use Aedart\Support\Helpers\Database\DbTrait;
use Illuminate\Database\ConnectionInterface;
use League\Flysystem\Config;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\PathPrefixer;
use League\Flysystem\UnableToCheckExistence;
use stdClass;
use Throwable;

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
     * Fetch a directory record from given table, which matches given path
     *
     * @param string $path
     * @param string $table
     * @param ConnectionInterface|null $connection [optional]
     *
     * @return stdClass|null
     *
     * @throws UnableToCheckExistence
     */
    protected function fetchDirectory(string $path, string $table, ConnectionInterface|null $connection = null): stdClass|null
    {
        try {
            $connection = $connection ?? $this->connection();

            $result = $connection
                ->table($table)
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
    protected function resolveTimestamp(Config $config): int
    {
        return $config->get('timestamp', time());
    }
}