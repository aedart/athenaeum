<?php

namespace Aedart\Filters\Processors;

use Aedart\Contracts\Database\Query\Operators\LogicalOperator;
use Aedart\Contracts\Filters\BuiltFiltersMap;
use Aedart\Filters\BaseProcessor;
use Aedart\Filters\Exceptions\InvalidParameter;

/**
 * Matching Processor
 *
 * Determines how filter constraints are to be added, e.g. via logical "AND" or via logical "OR".
 * The identified or chosen logical operator is stored in the built filters map, as "meta"
 *
 * @see \Aedart\Contracts\Filters\BuiltFiltersMap::meta
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Filters\Processors
 */
class MatchingProcessor extends BaseProcessor
{
    /**
     * Default logical operator to apply, when none specified.
     *
     * @var string
     */
    protected string $default = 'all';

    /**
     * Supported logical operators
     *
     * @var array<string, string> Key-value pair. Key => requested value, value = logical operator value
     */
    protected array $allowedMap = [
        'all' => LogicalOperator::AND->value,
        'any' => LogicalOperator::OR->value,
    ];

    /**
     * @inheritDoc
     */
    public function process(BuiltFiltersMap $built, callable $next): mixed
    {
        // Use requested logical operator or use default.
        $requested = $this->default;
        $value = $this->value();
        if (!empty($value)) {
            $requested = $value;
        }

        // Ensure requested matches a supported value,...
        if (!isset($this->allowedMap[$requested])) {
            throw InvalidParameter::make($this, sprintf('Unsupported operator. Allowed values are: %s', implode(', ', array_keys($this->allowedMap))));
        }

        $logicalOperator = $this->allowedMap[$requested];

        // Finally, set the operator to use as "meta" and proceed...
        return $next(
            $built->setMeta($this->parameter(), $logicalOperator)
        );
    }

    /**
     * Specify supported value and what logical operator it corresponds to
     *
     * @param string $value Requested / submitted value
     * @param string|LogicalOperator $logicalOperator Corresponding logical operator
     *
     * @return self
     */
    public function allows(string $value, string|LogicalOperator $logicalOperator): static
    {
        $this->allowedMap[$value] = match (true) {
            is_string($logicalOperator) => LogicalOperator::from($logicalOperator)->value,
            default => $logicalOperator->value
        };

        return $this;
    }
}
