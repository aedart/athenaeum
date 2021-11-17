<?php

namespace Aedart\Filters\Query\Filters\Concerns;

use RuntimeException;

/**
 * Concerns Database Driver
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Filters\Query\Filters\Concerns
 */
trait DatabaseDriver
{
    /**
     * Determines the "shorthand" database connection driver name
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query
     *
     * @return string
     *
     * @throws RuntimeException If unable to determine driver name
     */
    protected function determineDriver($query): string
    {
        $connection = $query->getConnection();

        // WARNING: getDriverName() is a public method that we use,
        // yet it's not specified in the interface.
        if (method_exists($connection, 'getDriverName')) {
            return $connection->getDriverName();
        }

        throw new RuntimeException(sprintf('Unable to determine shorthand connection driver name for %s', get_class($connection)));
    }
}
