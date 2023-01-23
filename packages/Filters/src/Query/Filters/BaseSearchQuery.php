<?php

namespace Aedart\Filters\Query\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;

/**
 * Base Search Query
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Filters\Query
 */
abstract class BaseSearchQuery extends BaseFilterQuery
{
    /**
     * Builds a search query for the given search term
     *
     * @param Builder|EloquentBuilder $query
     * @param string $search
     *
     * @return Builder|EloquentBuilder
     */
    abstract public function __invoke(Builder|EloquentBuilder $query, string $search): Builder|EloquentBuilder;
}
