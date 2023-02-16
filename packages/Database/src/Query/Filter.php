<?php

namespace Aedart\Database\Query;

use Aedart\Contracts\Database\Query\Criteria;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;

/**
 * Query Filter
 *
 * Base abstraction for database query filter
 *
 * @see \Aedart\Contracts\Database\Query\Criteria
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Database\Query
 */
abstract class Filter implements Criteria
{
    /**
     * @inheritdoc
     */
    public function isApplicable(Builder|EloquentBuilder|null $query = null, array $filters = []): bool
    {
        // By default, we assume that criteria can be applied. However,
        // you should overwrite this method, if a different determination logic
        // is required.
        //
        // Provided arguments can also be used. E.g. intended filters
        // can be searched to see whether conflicting criteria exist and thereby
        // exclude this filter. Alternatively, you may also use given query scope
        // to match already applied constraints as a basis for whether filter must
        // be applied or not.
        return true;
    }
}
