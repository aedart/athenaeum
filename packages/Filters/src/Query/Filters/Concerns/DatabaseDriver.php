<?php

namespace Aedart\Filters\Query\Filters\Concerns;

use Aedart\Database\Utils\Database;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\ConnectionInterface;
use RuntimeException;

/**
 * Concerns Database Driver
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Filters\Query\Filters\Concerns
 */
trait DatabaseDriver
{
    /**
     * Determines the Pdo driver used by given connection or query
     *
     * @param ConnectionInterface|Builder|EloquentBuilder $connection
     *
     * @return string
     *
     * @throws RuntimeException If unable to determine driver name
     */
    protected function determineDriver(ConnectionInterface|Builder|EloquentBuilder $connection): string
    {
        return Database::determineDriver($connection);
    }
}
