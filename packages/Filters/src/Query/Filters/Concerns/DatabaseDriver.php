<?php

namespace Aedart\Filters\Query\Filters\Concerns;

use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;
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
     * Determines the "shorthand" database connection driver name
     *
     * @param Builder|EloquentBuilder $query
     *
     * @return string
     *
     * @throws RuntimeException If unable to determine driver name
     */
    protected function determineDriver(Builder|EloquentBuilder $query): string
    {
        $connection = $query->getConnection();

        // WARNING: getDriverName() is a public method that we use,
        // yet it's not specified in the interface.
        if (method_exists($connection, 'getDriverName')) {
            return $connection->getDriverName();
        }

        throw new RuntimeException(sprintf('Unable to determine shorthand connection driver name for %s', $connection::class));
    }
}
