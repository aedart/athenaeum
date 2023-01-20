<?php

namespace Aedart\Filters\Query\Filters\Fields;

use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;

/**
 * String Filter
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Filters\Query\Filters\Fields
 */
class StringFilter extends BaseFieldFilter
{
    /**
     * @inheritDoc
     */
    public function apply(Builder|EloquentBuilder $query): Builder|EloquentBuilder
    {
        $operator = $this->operator();

        return match ($operator) {
            'contains' => $this->buildWhereContainsConstraint($query),
            'not_contains' => $this->buildWhereNotContainsConstraint($query),
            'starts_with' => $this->buildWhereStartsWithConstraint($query),
            'not_starts_with' => $this->buildWhereNotStartsWithConstraint($query),
            'ends_with' => $this->buildWhereEndsWithConstraint($query),
            'not_ends_with' => $this->buildWhereNotEndsWithConstraint($query),
            'in' => $this->buildWhereInConstraint($query),
            'not_in' => $this->buildWhereNotInConstraint($query),
            'is_null' => $this->buildWhereNullConstraint($query),
            'not_null' => $this->buildWhereNotNullConstraint($query),
            default => $this->buildDefaultConstraint($query)
        };
    }

    /**
     * @inheritDoc
     */
    public function operatorAliases(): array
    {
        return [
            'eq' => '=',
            'ne' => '!=',

            // NOTE: Values do NOT correspond directly to sql operators for these...
            'is_null' => 'is_null',
            'not_null' => 'not_null',
            'in' => 'in',
            'not_in' => 'not_in',
            'contains' => 'contains',
            'not_contains' => 'not_contains',
            'starts_with' => 'starts_with',
            'not_starts_with' => 'not_starts_with',
            'ends_with' => 'ends_with',
            'not_ends_with' => 'not_ends_with',
        ];
    }
}
