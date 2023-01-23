<?php

namespace Aedart\Filters\Query\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;

/**
 * Base Sorting Query
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Filters\Query\Filters
 */
abstract class BaseSortingQuery extends BaseFilterQuery
{
    /**
     * Builds a "order by ..." query for the given column and sorting direction
     *
     * @param Builder|EloquentBuilder $query
     * @param string $column
     * @param string $direction [optional] asc or desc
     *
     * @return Builder|EloquentBuilder
     */
    abstract public function __invoke(Builder|EloquentBuilder $query, string $column, string $direction = 'asc'): Builder|EloquentBuilder;
}
