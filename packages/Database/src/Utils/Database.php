<?php

namespace Aedart\Database\Utils;

use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\ConnectionInterface;
use RuntimeException;

/**
 * Database (Utilities)
 *
 * Offers various database, connection and query utilities.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Database\Utils
 */
class Database
{
    /**
     * Determine the Pdo driver name that is used by given connection or query
     *
     * @param ConnectionInterface|Builder|EloquentBuilder $connection
     *
     * @return string
     */
    public static function determineDriver(ConnectionInterface|Builder|EloquentBuilder $connection): string
    {
        if ($connection instanceof Builder) {
            $connection = $connection->getConnection();
        }

        // WARNING: getDriverName() is a public method that we use,
        // yet it's not specified in the interface.
        if (method_exists($connection, 'getDriverName')) {
            return $connection->getDriverName();
        }

        throw new RuntimeException(sprintf('Unable to determine Pdo driver name for %s', $connection::class));
    }
}