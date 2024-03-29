<?php

namespace Aedart\Contracts\Database\Query;

use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;

/**
 * Criteria (Query Filter)
 *
 * A criteria or constraint to be applied on a database query. Think of this as a filter...
 *
 * Inspired by Mirza Pasic's "Repository Pattern", Laravel's global query scopes and the "specification design pattern".
 *
 * @see https://bosnadev.com/2015/03/07/using-repository-pattern-in-laravel-5/
 * @see https://laravel.com/docs/8.x/eloquent#applying-global-scopes
 * @see https://en.wikipedia.org/wiki/Specification_pattern
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Database\Query
 */
interface Criteria
{
    /**
     * Determine if criteria is applicable
     *
     * Method is intended to be invoked, before criteria is attempted applied.
     * It accepts the evt. current query scope as well as a list of other
     * criteria intended to be applied. These parameters can be used
     * for determining if criteria should be applied or avoided.
     *
     * @param Builder|EloquentBuilder|null $query [optional] Evt. current query scope
     * @param Criteria[] $filters [optional] List of intended criteria to be applied, along with this criteria
     *
     * @return bool
     */
    public function isApplicable(Builder|EloquentBuilder|null $query = null, array $filters = []): bool;

    /**
     * Apply criteria
     *
     * @param Builder|EloquentBuilder $query
     *
     * @return Builder|EloquentBuilder
     */
    public function apply(Builder|EloquentBuilder $query): Builder|EloquentBuilder;
}
