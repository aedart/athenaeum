<?php

namespace Aedart\Filters\Query\Filters;

use Aedart\Database\Concerns\Prefixing;
use Aedart\Database\Query\Concerns\Joins;

/**
 * Base Filter Query
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Filters\Query\Filters
 */
abstract class BaseFilterQuery
{
    use Prefixing;
    use Joins;

    /**
     * Creates a new filter query instance
     *
     * @param string|null $tablePrefix [optional] Evt. table name for columns prefixing
     */
    public function __construct(
        protected string|null $tablePrefix = null
    ) {
    }

    /**
     * Returns table prefix
     *
     * @return string|null
     */
    public function tablePrefix(): string|null
    {
        return $this->tablePrefix;
    }
}
