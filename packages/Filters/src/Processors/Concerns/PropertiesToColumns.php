<?php

namespace Aedart\Filters\Processors\Concerns;

/**
 * Properties To Columns
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Filters\Processors\Concerns
 */
trait PropertiesToColumns
{
    /**
     * Map of requested (allowed) properties and what
     * their corresponding database table column.
     *
     * @var array
     */
    protected array $propertiesToColumnsMap = [];

    /**
     * Specify a map of requested properties and their corresponding database
     * table column name
     *
     * Example:
     * ```
     * $processor->propertiesToColumns([
     *      'user' => 'user_id'
     * ]);
     * ```
     *
     * @param array $map Key-value pairs, key = requested property, value = table column name
     *
     * @return self
     */
    public function propertiesToColumns(array $map)
    {
        $this->propertiesToColumnsMap = $map;

        return $this;
    }

    /**
     * Resolves the table column name that matches for the given
     * property
     *
     * @param string $property
     *
     * @return string Column name or given property, if no column name
     *                was specified.
     */
    protected function resolveColumnName(string $property): string
    {
        if (isset($this->propertiesToColumnsMap[$property])) {
            return $this->propertiesToColumnsMap[$property];
        }

        return $property;
    }
}
