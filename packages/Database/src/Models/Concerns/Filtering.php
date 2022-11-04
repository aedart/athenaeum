<?php

namespace Aedart\Database\Models\Concerns;

use Aedart\Contracts\Database\Query\Criteria;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;

/**
 * Concerns Filtering
 *
 * Able to apply one or more criteria (filters) on model query.
 *
 * @see Criteria
 *
 * @method static Builder|EloquentBuilder applyFilters(Criteria|Criteria[] $filters) Apply one or more filters (criteria). Method will not apply filters that are not applicable.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Database\Models\Concerns
 */
trait Filtering
{
    /**
     * Scope query to apply one or more filters (criteria)
     *
     * Method will not apply filters that are not applicable.
     *
     * @see Criteria::isApplicable
     *
     * @param Builder|EloquentBuilder $query
     * @param Criteria|Criteria[] $filters
     *
     * @return Builder|EloquentBuilder
     */
    public function scopeApplyFilters(Builder|EloquentBuilder $query, Criteria|array $filters = []): Builder|EloquentBuilder
    {
        if (!is_array($filters)) {
            $filters = [ $filters ];
        }

        foreach ($filters as $filter) {
            // Skip if filter is not applicable
            if (!$filter->isApplicable($query, $filters)) {
                continue;
            }

            // Apply scope
            $query = $filter->apply($query);
        }

        return $query;
    }
}
