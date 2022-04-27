<?php

namespace Aedart\Flysystem\Db\Adapters;

use Aedart\Contracts\Support\Helpers\Database\DbAware;
use Aedart\Flysystem\Db\Exceptions\ConnectionException;
use Aedart\Support\Helpers\Database\DbTrait;
use Illuminate\Database\ConnectionInterface;
use League\Flysystem\FilesystemAdapter;
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
}