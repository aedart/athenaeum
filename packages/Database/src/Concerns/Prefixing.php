<?php

namespace Aedart\Database\Concerns;

use Aedart\Database\Utils\Database;

/**
 * Concerns Prefixing
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Database\Concerns
 */
trait Prefixing
{
    /**
     * Prefixes columns with a table name
     *
     * @param string[]|callable[] $columns
     * @param string|null $prefix [optional] E.g. table name
     *
     * @return string[]|callable[]
     */
    public function prefixColumns(array $columns, string|null $prefix = null): array
    {
        return Database::prefixColumns($columns, $prefix);
    }
}
