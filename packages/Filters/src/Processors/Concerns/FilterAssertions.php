<?php

namespace Aedart\Filters\Processors\Concerns;

use Aedart\Filters\Exceptions\InvalidParameter;
use Aedart\Support\Helpers\Translation\TranslatorTrait;

/**
 * Concerns Filter Assertions
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Filters\Processors\Concerns
 */
trait FilterAssertions
{
    use TranslatorTrait;

    /**
     * Assert properties are supported / allowed and the criteria
     * value that was requested.
     *
     * @param array $requested
     * @param string[] $allowed
     *
     * @return self
     *
     * @throws InvalidParameter
     */
    protected function assertProperties(array $requested, array $allowed): static
    {
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
    protected function assertPropertyIsAllowed(string $property, array $allowed): static
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
    protected function assertPropertyCriteria(string $property, mixed $criteria): static
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
    protected function assertPropertyCriteriaValue(string $property, mixed $value): static
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
    protected function assertNumericCriteriaValue(string $property, int|float $value): static
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
    protected function assertStringCriteriaValue(string $property, string $value): static
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
    protected function assertArrayOfFiltersRequested(mixed $requested): static
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
     * @param int $maxFilters [optional]
     *
     * @return self
     *
     * @throws InvalidParameter
     */
    protected function assertNotTooManyFiltersRequested(array $requested, int $maxFilters = 10): static
    {
        // Applying "where ..." clauses can quickly become a costly affair,
        // so here we ensure that requested amount of filters does not exceed
        // a specified max.
        if (count($requested) > $maxFilters) {
            $translator = $this->getTranslator();

            throw InvalidParameter::make($this, $translator->get('validation.lte.array', [
                'attribute' => $this->parameter(),
                'value' => $maxFilters
            ]));
        }

        return $this;
    }
}
