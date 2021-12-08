<?php

namespace Aedart\Filters\Processors;

use Aedart\Contracts\Database\Query\Exceptions\CriteriaException;
use Aedart\Contracts\Database\Query\Exceptions\InvalidOperatorException;
use Aedart\Contracts\Database\Query\FieldCriteria;
use Aedart\Contracts\Filters\BuiltFiltersMap;
use Aedart\Filters\BaseProcessor;
use Aedart\Filters\Exceptions\InvalidParameter;
use Aedart\Support\Helpers\Translation\TranslatorTrait;
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
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Filters\Processors
 */
class ConstraintsProcessor extends BaseProcessor
{
    use TranslatorTrait;
    use Concerns\PropertiesToColumns;

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
    public function process(BuiltFiltersMap $built, callable $next)
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
    public function filters(array $map)
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
    public function maxFilters(int $max = 10)
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
    public function matchFrom(string $metaKey = 'match')
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
     * @param string $property Name of requested property to build a constraint filter for
     * @param array $criteria Key-value pair, key = operator, value = mixed
     * @param string $logical Logical boolean operator that determines how filters'
     *                        where clauses should be applied, e.g. "AND" or "OR"
     * @param BuiltFiltersMap $built
     *
     * @return BuiltFiltersMap
     *
     * @throws InvalidParameter
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
     * @throws \Aedart\Contracts\Filters\Exceptions\ProcessorException
     */
    protected function buildFilter(
        string $property,
        string $operator,
        $value,
        string $logical = FieldCriteria::AND
    ): FieldCriteria {
        // Resolve column name from given property
        $column = $this->resolveColumnName($property);

        // Attempt to build the filter for the requested property.
        try {
            $filter = $this->filtersMap[$property];

            // Create instance if class path provided
            if (is_string($filter)) {
                return $filter::make($column, $operator, $value, $logical);
            }

            // (Re)-configure if instance was provided
            if ($filter instanceof FieldCriteria) {
                return $filter
                    ->setField($column)
                    ->setOperator($operator)
                    ->setLogical($logical)
                    ->setValue($value);
            }

            // Fail otherwise...
            throw new LogicException(sprintf('Invalid filter for property %s. Expected a class path or FieldCriteria instance', $property));
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
    protected function resolveOperator($operator): string
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
    protected function resolveValue($value)
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
    protected function validateRequestedFilters($requested)
    {
        $this
            ->assertArrayOfFiltersRequested($requested)
            ->assertNotTooManyFiltersRequested($requested)
            ->assertProperties($requested);
    }

    /**
     * Assert properties are supported / allowed and the criteria
     * value that was requested.
     *
     * @param array $requested
     *
     * @return self
     *
     * @throws InvalidParameter
     */
    protected function assertProperties(array $requested)
    {
        $allowed = array_keys($this->filtersMap);

        foreach ($requested as $property => $criteria) {
            $this
                ->assertPropertyIsAllowed($property, $allowed)
                ->assertPropertyCriteria($property, $criteria);
        }

        return $this;
    }

    /**
     * Assert that requested property is supported / allowed
     *
     * @param string $property Requested property
     * @param string[] $allowed List of allowed / supported properties
     *
     * @return self
     *
     * @throws InvalidParameter
     */
    protected function assertPropertyIsAllowed(string $property, array $allowed)
    {
        if (!in_array($property, $allowed)) {
            throw InvalidParameter::forParameter(
                $this->parameter() . '.' . $property,
                $this,
                sprintf('%s is not supported as a filterable property', $property)
            );
        }

        return $this;
    }

    /**
     * Assert requested property criteria
     *
     * Method ignores evt. criteria operators and validates only the requested
     * values.
     *
     * @see assertPropertyCriteriaValue
     *
     * @param string $property
     * @param mixed $criteria
     *
     * @return self
     *
     * @throws InvalidParameter
     */
    protected function assertPropertyCriteria(string $property, $criteria)
    {
        // A property's criteria is intended to be an array consistent of
        // "operator => value". This might not always be the case, so here
        // we need to ensure that it is, before extracting the value...
        if (!is_array($criteria)) {
            $criteria = [ $criteria ];
        }

        // Assert each criteria value
        foreach ($criteria as $value) {
            $this->assertPropertyCriteriaValue($property, $value);
        }

        return $this;
    }

    /**
     * Assert property criteria value
     *
     * @param string $property
     * @param mixed $value
     *
     * @return self
     *
     * @throws InvalidParameter
     */
    protected function assertPropertyCriteriaValue(string $property, $value)
    {
        // The "best" we can do here, is just ensure that value's content does
        // not exceed a certain character limit. Overwrite this method, if more
        // advanced value validation is required.

        // Allow empty / null value, as some filters might be able to
        // deal with such...
        if (empty($value)) {
            return $this;
        }

        if (is_numeric($value)) {
            $this->assertNumericCriteriaValue($property, $value);
        } elseif (is_string($value)) {
            $this->assertStringCriteriaValue($property, $value);
        }

        return $this;
    }

    /**
     * Assert numeric criteria value for given property
     *
     * @param string $property
     * @param int|float $value
     *
     * @return self
     *
     * @throws InvalidParameter
     */
    protected function assertNumericCriteriaValue(string $property, $value)
    {
        $parameter = $this->parameter() . '.' . $property;
        $min = PHP_INT_MIN;
        $max = PHP_INT_MAX;

        $translator = $this->getTranslator();

        if ($value < $min) {
            throw InvalidParameter::forParameter($parameter, $this, $translator->get('validation.min.numeric', [ 'attribute' => $property, 'min' => $min ]));
        }

        if ($value > $max) {
            throw InvalidParameter::forParameter($parameter, $this, $translator->get('validation.max.numeric', [ 'attribute' => $property, 'max' => $max ]));
        }

        return $this;
    }

    /**
     * Assert string criteria value for given property
     *
     * @param string $property
     * @param string $value
     *
     * @return self
     *
     * @throws InvalidParameter
     */
    protected function assertStringCriteriaValue(string $property, string $value)
    {
        $parameter = $this->parameter() . '.' . $property;
        $min = 1;
        $max = 255;
        $length = mb_strlen($value);

        $translator = $this->getTranslator();

        if ($length < $min) {
            throw InvalidParameter::forParameter($parameter, $this, $translator->get('validation.min.string', [ 'attribute' => $property, 'min' => $min ]));
        }

        if ($length > $max) {
            throw InvalidParameter::forParameter($parameter, $this, $translator->get('validation.max.string', [ 'attribute' => $property, 'max' => $max ]));
        }

        return $this;
    }

    /**
     * Assert that requested filters is an array
     *
     * @param mixed $requested
     *
     * @return self
     *
     * @throws InvalidParameter
     */
    protected function assertArrayOfFiltersRequested($requested)
    {
        // We expect the requested constraint filters to be in array
        // format - fail if this is not the case.
        if (!is_array($requested)) {
            throw InvalidParameter::make($this, sprintf(
                'Incorrect syntax. Please request filter using the following syntax: %s[name-of-property][operator]=value',
                $this->parameter()
            ));
        }

        return $this;
    }

    /**
     * Assert that not too many filters are requested
     *
     * @param array $requested
     *
     * @return self
     *
     * @throws InvalidParameter
     */
    protected function assertNotTooManyFiltersRequested(array $requested)
    {
        // Applying "where ..." clauses can quickly become a costly affair,
        // so here we ensure that requested amount of filters does not exceed
        // a specified max.
        if (count($requested) > $this->maxFilters) {
            $translator = $this->getTranslator();

            throw InvalidParameter::make($this, $translator->get('validation.lte.array', [
                'attribute' => $this->parameter(),
                'value' => $this->maxFilters
            ]));
        }

        return $this;
    }
}
