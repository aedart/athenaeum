<?php

namespace Aedart\Database\Query;

use Aedart\Contracts\Database\Query\Criteria;

/**
 * Query Filter
 *
 * Base abstraction for database query filter
 *
 * @see \Aedart\Contracts\Database\Query\Criteria
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Database\Query
 */
abstract class Filter implements Criteria
{
    /**
     * @inheritdoc
     */
    public function isApplicable($query = null, $filters = []): bool
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