<?php

namespace Aedart\Filters\Processors;

use Aedart\Contracts\Database\Query\Exceptions\CriteriaException;
use Aedart\Contracts\Database\Query\Exceptions\InvalidOperatorException;
use Aedart\Contracts\Database\Query\FieldCriteria;
use Aedart\Contracts\Filters\BuiltFiltersMap;
use Aedart\Contracts\Filters\Exceptions\ProcessorException;
use Aedart\Filters\BaseProcessor;
use Aedart\Filters\Exceptions\InvalidParameter;
use InvalidArgumentException;
use LogicException;

/**
 * Constraints Processor
 *
 * Responsible for building "constraint" filters that are requested via the
 * http query.
 *
 * Be default, this processor expects that constraint filters have the following
 * format: "[name-of-parameter][property][operator]=value", e.g. `filter[age][gt]=24`
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Filters\Processors
 */
class ConstraintsProcessor extends BaseProcessor
{
    use Concerns\PropertiesToColumns;
    use Concerns\FilterAssertions;

    /**
     * Filters map
     *
     * @var array Key-value pair, key = requested property, value = field filter class path
     */
    protected array $filtersMap = [];

    /**
     * Maximum amount of filters that can be requested
     *
     * @var int
     */
    protected int $maxFilters = 10;

    /**
     * Meta key name that holds "matching" logical boolean
     * operator
     *
     * @var string
     */
    protected string $matchingKey = 'match';

    /**
     * @inheritDoc
     */
    public function process(BuiltFiltersMap $built, callable $next): mixed
    {
        // Skip this processor, if no value was submitted; no filters requested!
        $requested = $this->value();
        if (empty($requested)) {
            return $next($built);
        }

        // Validate the basic syntax and properties and resolve the logical boolean
        // operator (add filters via "AND" or via "OR" clauses)
        $this->validateRequestedFilters($requested);
        $logical = $this->resolveLogicalBooleanOperator($built);

        // Build constraint filters for each requested...
        foreach ($requested as $property => $criteria) {
            // The property's "criteria" should consist of an operator => value.
            // But, in some situations it might have been omitted and only contain
            // a value. To ensure correct processing, we convert the criteria
            // to an array, if anything else was submitted.
            if (!is_array($criteria)) {
                $criteria = [ $criteria ];
            }

            $built = $this->addFiltersForCriteria($property, $criteria, $logical, $built);
        }

        return $next($built);
    }

    /**
     * Specify the filters to be used for each property that is filterable
     *
     * ```
     * $processor->filters([
     *      'name' => StringFilter::class,
     *      'age' => AgeFilter::class,
     *      'created_at' => DateFilter::class,
     * ]);
     * ```
     *
     * **Note**: Filters must be an instance of `FieldCriteria`
     *
     * @see FieldCriteria
     *
     * @param array $map Key-value pair. Key = requested property, value = filter class path
     *
     * @return self
     */
    public function filters(array $map): static
    {
        $this->filtersMap = $map;

        return $this;
    }

    /**
     * Set the maximum amount of filters that is allowed requested
     *
     * @param int $max [optional]
     *
     * @return self
     */
    public function maxFilters(int $max = 10): static
    {
        $this->maxFilters = $max;

        return $this;
    }

    /**
     * Set the meta key name that holds the "matching" logical
     * boolean operator
     *
     * @see \Aedart\Filters\Processors\MatchingProcessor
     *
     * @param string $metaKey [optional]
     *
     * @return self
     */
    public function matchFrom(string $metaKey = 'match'): static
    {
        $this->matchingKey = $metaKey;

        return $this;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Builds constraint filters for requested property and adds them to the
     * provided built filters instance
     *
     * @param  string  $property  Name of requested property to build a constraint filter for
     * @param  array  $criteria  Key-value pair, key = operator, value = mixed
     * @param  string  $logical  Logical boolean operator that determines how filters'
     *                        where clauses should be applied, e.g. "AND" or "OR"
     * @param  BuiltFiltersMap  $built
     *
     * @return BuiltFiltersMap
     *
     * @throws CriteriaException
     * @throws ProcessorException
     */
    protected function addFiltersForCriteria(
        string $property,
        array $criteria,
        string $logical,
        BuiltFiltersMap $built
    ): BuiltFiltersMap {
        $parameter = $this->parameter();

        foreach ($criteria as $operator => $value) {
            // Resolve the operator and value
            $operator = $this->resolveOperator($operator);
            $value = $this->resolveValue($value);

            // Regardless of what the logical operator was submitted or resolved to, the very
            // first filter MUST be added via an "AND" operator. Laravel's query builder will
            // do the reset, in case that an "OR" operator was requested. E.g. it will
            // automatically group "OR" expressions.
            $appliedLogical = !$built->has($parameter)
                ? FieldCriteria::AND
                : $logical;

            $filter = $this->buildFilter($property, $operator, $value, $appliedLogical);

            // Finally, add the built filter to the list of filters for the requested parameter.
            $built->add($parameter, $filter);
        }

        return $built;
    }

    /**
     * Build filter for the requested property
     *
     * @param string $property Requested property. Method will automatically resolve it to
     *                         appropriate table column name.
     * @param string $operator
     * @param mixed $value
     * @param string $logical [optional] Logical boolean operator; if constraint filter should be
     *                        be applied using "AND" or via "OR" clauses...
     *
     * @return FieldCriteria
     *
     * @throws InvalidParameter
     * @throws LogicException If filter is invalid, e.g. not class path or FieldCriteria instance
     * @throws CriteriaException
     * @throws ProcessorException
     */
    protected function buildFilter(
        string $property,
        string $operator,
        mixed $value,
        string $logical = FieldCriteria::AND
    ): FieldCriteria {
        // Resolve column name from given property
        $column = $this->resolveColumnName($property);

        // Attempt to build the filter for the requested property.
        try {
            $filter = $this->filtersMap[$property];

            // Create a new filter when class path is provided, or copy given
            // filter instance.
            return match (true) {
                is_string($filter) => $this->makeFilter($filter, $column, $operator, $value, $logical),
                $filter instanceof FieldCriteria => $this->copyFilter($filter, $column, $operator, $value, $logical),
                default => throw new LogicException(sprintf('Invalid filter for property %s. Expected a class path or FieldCriteria instance', $property))
            };
        } catch (InvalidOperatorException $e) {
            // To ensure that the correct parameter (e.g. filter.[property]) is specified,
            // we need to create the correct parameter name,
            $param = $this->parameter() . '.' . $property;

            throw InvalidParameter::forParameter(
                $param,
                $this,
                sprintf('Invalid operator for %s. %s', $property, $e->getMessage())
            );
        } catch (InvalidArgumentException $e) {
            // Ensure correct parameter...
            $param = $this->parameter() . '.' . $property;

            throw InvalidParameter::forParameter($param, $this, $e->getMessage());
        }
    }

    /**
     * Creates a new filter instance from class path
     *
     * @param string $class Class path to {@see FieldCriteria}
     * @param string $column
     * @param string $operator
     * @param mixed $value
     * @param string $logical [optional] Logical boolean operator; if constraint filter should be
     *                        be applied using "AND" or via "OR" clauses...
     *
     * @return FieldCriteria

     * @throws CriteriaException
     * @throws InvalidOperatorException
     */
    protected function makeFilter(
        string $class,
        string $column,
        string $operator,
        mixed $value,
        string $logical = FieldCriteria::AND
    ): FieldCriteria {
        return $class::make($column, $operator, $value, $logical);
    }

    /**
     * Copies given filter instance and sets new field, operator... etc
     *
     * @param FieldCriteria $filter
     * @param string $newColumn
     * @param string $newOperator
     * @param mixed $newValue
     * @param string $newLogical [optional]
     *
     * @return FieldCriteria
     *
     * @throws CriteriaException
     * @throws InvalidOperatorException
     */
    protected function copyFilter(
        FieldCriteria $filter,
        string $newColumn,
        string $newOperator,
        mixed $newValue,
        string $newLogical = FieldCriteria::AND
    ): FieldCriteria {
        return (clone $filter)
            ->setField($newColumn)
            ->setOperator($newOperator)
            ->setValue($newValue)
            ->setLogical($newLogical);
    }

    /**
     * Resolves the table column name that matches for the given
     * property
     *
     * @param string $property
     *
     * @return string
     */
    protected function resolveColumnName(string $property): string
    {
        if (isset($this->propertiesToColumnsMap[$property])) {
            return $this->propertiesToColumnsMap[$property];
        }

        return $property;
    }

    /**
     * Extracts / resolves operator from requested filter value
     *
     * @param mixed $operator
     *
     * @return string
     */
    protected function resolveOperator(mixed $operator): string
    {
        if (!is_int($operator)) {
            return $operator;
        }

        // Default to "equals" operator, when anything else was provided
        return 'eq';
    }

    /**
     * Extract / resolve value
     *
     * @param mixed $value
     *
     * @return mixed
     */
    protected function resolveValue(mixed $value): mixed
    {
        // By default, value is passed on as given. Overwrite this
        // method, in case that special value processing is required
        // at this level of processing...
        return $value;
    }

    /**
     * Resolves the logical boolean operator
     *
     * @param BuiltFiltersMap $built
     *
     * @return string
     */
    protected function resolveLogicalBooleanOperator(BuiltFiltersMap $built): string
    {
        return $built->getMeta($this->matchingKey, FieldCriteria::AND);
    }

    /**
     * Validates requested filters
     *
     * @param mixed $requested
     */
    protected function validateRequestedFilters(mixed $requested)
    {
        $allowed = array_keys($this->filtersMap);

        $this
            ->assertArrayOfFiltersRequested($requested)
            ->assertNotTooManyFiltersRequested($requested, $this->maxFilters)
            ->assertProperties($requested, $allowed);
    }
}
