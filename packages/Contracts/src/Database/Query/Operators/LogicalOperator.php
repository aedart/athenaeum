<?php

namespace Aedart\Contracts\Database\Query\Operators;

/**
 * Logical Operator
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Database\Query\Operators
 */
enum LogicalOperator: string
{
    /**
     * Logical 'and' operator
     */
    case AND = 'and';

    /**
     * Logical 'or' operator
     */
    case OR = 'or';

    /**
     * Returns all cases' values
     *
     * @return string[]
     */
    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
