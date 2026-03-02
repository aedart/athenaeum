<?php

namespace Aedart\Contracts\Database\Query\Operators;

use Aedart\Contracts\Utils\Enums\Concerns;

/**
 * Logical Operator
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Database\Query\Operators
 */
enum LogicalOperator: string
{
    use Concerns\BackedEnums;

    /**
     * Logical 'and' operator
     */
    case AND = 'and';

    /**
     * Logical 'or' operator
     */
    case OR = 'or';
}
