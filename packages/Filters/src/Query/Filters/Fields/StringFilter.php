<?php

namespace Aedart\Filters\Query\Filters\Fields;

/**
 * String Filter
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Filters\Query\Filters\Fields
 */
class StringFilter extends BaseFieldFilter
{
    /**
     * @inheritDoc
     */
    public function apply($query)
    {
        $operator = $this->operator();

        switch ($operator) {
            case 'contains':
                return $this->buildWhereContainsConstraint($query);

            case 'not_contains':
                return $this->buildWhereNotContainsConstraint($query);

            case 'starts_with':
                return $this->buildWhereStartsWithConstraint($query);

            case 'not_starts_with':
                return $this->buildWhereNotStartsWithConstraint($query);

            case 'ends_with':
                return $this->buildWhereEndsWithConstraint($query);

            case 'not_ends_with':
                return $this->buildWhereNotEndsWithConstraint($query);

            case 'in':
                return $this->buildWhereInConstraint($query);

            case 'not_in':
                return $this->buildWhereNotInConstraint($query);

            case 'is_null':
                return $this->buildWhereNullConstraint($query);

            case 'not_null':
                return $this->buildWhereNotNullConstraint($query);

            default:
                return $this->buildDefaultConstraint($query);
        }
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
