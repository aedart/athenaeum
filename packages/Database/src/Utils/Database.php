<?php

namespace Aedart\Database\Utils;

use Aedart\Utils\Str;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\ConnectionInterface;
use RuntimeException;

/**
 * Database (Utilities)
 *
 * Offers various database, connection and query utilities.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
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

    /**
     * Prefixes columns with a table name
     *
     * @see prefixColumn
     *
     * @param string[]|callable[] $columns
     * @param string|null $prefix [optional] E.g. table name
     *
     * @return string[]|callable[]
     */
    public static function prefixColumns(array $columns, string|null $prefix = null): array
    {
        if (empty($prefix)) {
            return $columns;
        }

        return array_map(function ($column) use ($prefix) {
            return static::prefixColumn($column, $prefix);
        }, $columns);
    }

    /**
     * Prefix given column with a table name
     *
     * If column is a callback, then the callback is just returned!
     *
     * @param string|callable $column Name of column or callback
     * @param string|null $prefix [optional] E.g. table name
     *
     * @return string|callable
     */
    public static function prefixColumn(string|callable $column, string|null $prefix = null): string|callable
    {
        if (empty($prefix)) {
            return $column;
        }

        if (is_callable($column)) {
            return $column;
        }

        // Skip prefixing, if columns is already prefixed
        $prefix = "{$prefix}.";
        if (Str::startsWith($column, $prefix)) {
            return $column;
        }

        return "{$prefix}{$column}";
    }
}
