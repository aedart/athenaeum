<?php

namespace Aedart\Filters\Processors;

use Aedart\Contracts\Database\Query\Criteria;
use Aedart\Contracts\Filters\BuiltFiltersMap;
use Aedart\Filters\BaseProcessor;
use Aedart\Filters\Exceptions\InvalidParameter;
use Aedart\Filters\Query\Filters\SortFilter;
use LogicException;

/**
 * Sorting Processor
 *
 * Builds a sorting filter, acc. to the requested properties results
 * must be sorted by.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Filters\Processors
 */
class SortingProcessor extends BaseProcessor
{
    use Concerns\PropertiesToColumns;

    /**
     * List of sortable properties (the allowed properties)
     *
     * @var string[]
     */
    protected array $sortable = [];

    /**
     * Map of sorting directions
     *
     * @var string[] Key-value pairs, key = requested identifier, value = sql sorting direction
     */
    protected array $directions = [
        'asc' => 'asc',
        'desc' => 'desc'
    ];

    /**
     * Maximum amount of properties that results can be
     * sorted by
     *
     * @var int
     */
    protected int $maxSortingProperties = 3;

    /**
     * Default sorting value to be applied, in case
     * that none was requested.
     *
     * @var string
     */
    protected string $defaultSortValue = '';

    /**
     * The delimiter to use when multiple properties
     * are requested sorted by.
     *
     * @var string
     */
    protected string $delimiter = ',';

    /**
     * @inheritDoc
     */
    public function process(BuiltFiltersMap $built, callable $next)
    {
        // Obtain requested or default
        $value = !empty($this->value())
            ? $this->value()
            : $this->defaultSortValue;

        // If by any chance no sorting value was requested and default
        // is empty, then we must skip this processor.
        if (empty($value)) {
            return $next($built);
        }

        // Extract the columns and directions to sort results by.
        // Created and add sorting filter
        $columns = $this->extractRequestedSortBy($value);

        $built->add(
            $this->parameter(),
            $this->makeFilter($columns)
        );

        return $next($built);
    }

    /**
     * Set the properties that are sortable
     *
     * @see propertiesToColumns
     *
     * @param string[] $properties
     *
     * @return $this
     */
    public function sortable(array $properties)
    {
        $this->sortable = $properties;

        return $this;
    }

    /**
     * Set the sorting directions map.
     *
     * Maps must contain the sorting direction tokens that can be
     * requested and their corresponding sql sorting direction.
     *
     * Example:
     * ```
     * $processor->directions([
     *      '+' => 'asc',
     *      '-' => 'desc'
     * ]);
     * ```
     *
     * @param string[] $map Key-value pairs, key = requested identifier, value = sql sorting direction
     *
     * @return self
     */
    public function directions(array $map)
    {
        $this->directions = $map;

        return $this;
    }

    /**
     * Set the maximum amount of properties that results can be
     * sorted by
     *
     * @param int $max [optional]
     *
     * @return self
     */
    public function maxSortingProperties(int $max = 3)
    {
        $this->maxSortingProperties = $max;

        return $this;
    }

    /**
     * Set the default request sorting value to be applied,
     * when none is requested.
     *
     * @param string $value E.g. "id desc, name asc" or however
     *                      sorting values are intended received in
     *                      the http query parameter
     *
     * @return self
     */
    public function defaultSort(string $value)
    {
        $this->defaultSortValue = $value;

        return $this;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Creates a new filter instance
     *
     * @param array $columns
     *
     * @return Criteria
     */
    public function makeFilter(array $columns): Criteria
    {
        return new SortFilter($columns);
    }

    /**
     * Extract the table columns and sorting direction from given
     * requested value...
     *
     * @param string|array $value
     *
     * @return array key-value pair, key = table column, value = sorting direction
     *
     * @throws InvalidParameter
     * @throws LogicException When incorrect value format is given
     */
    protected function extractRequestedSortBy($value): array
    {
        if (is_string($value)) {
            $value = $this->extractListFromRequested($value, $this->delimiter);
        }

        if (!is_array($value)) {
            throw new LogicException('Unable to extract sorting columns, value is not an array');
        }

        // Abort if too many properties are requested
        $this->assertNotTooManyPropertiesToSortBy($value);

        // The given list is assumed to consist of string values that contain
        // property and sorting direction. These need to be converted to a
        // different structure, so that it can be passed on to a query filter.
        // The final output must be a key-value pair;
        //      key = table column
        //      value = sorting direction (asc|desc)
        $output = [];

        foreach ($value as $item) {
            // Assert and split item into a small array that contains sortable
            // property and sorting direction (optional).
            $parts = $this->splitSortableItem($item);

            // Extract the table column and sorting sql direction token.
            // Both methods will fail, if property or direction are not supported...
            $column = $this->extractSortingColumn($parts);
            $direction = $this->extractSortingDirection($parts);

            // Finally, add to list of columns
            $output[$column] = $direction;
        }

        return $output;
    }

    /**
     * Extracts the table column name from given requested item "parts"
     *
     * @param string[] $parts
     *
     * @return string
     *
     * @throws InvalidParameter If requested property is not sortable (or known)
     */
    protected function extractSortingColumn(array $parts): string
    {
        $property = $parts[0];
        $this->assertPropertyIsAllowed($property, $this->sortable);

        return $this->resolveColumnName($property);
    }

    /**
     * Extracts the sql sorting direction from given requested item "parts"
     *
     * @param string[] $parts
     *
     * @return string
     *
     * @throws InvalidParameter If requested sorting direction is not supported / known
     */
    protected function extractSortingDirection(array $parts): string
    {
        // Obtain the identifier or default to "ascending".
        $identifier = $parts[1] ?? 'asc';

        return $this->resolveSqlSortingDirection($identifier);
    }

    /**
     * Split the requested sort item into a small array
     * that contains name of property and evt. sorting direction.
     *
     * @param string $item
     *
     * @return string[]
     *
     * @throws InvalidParameter
     */
    protected function splitSortableItem(string $item): array
    {
        // Ensure that the "item" is no empty. If so, then a malformed
        // request has been received. Thus, we must abort.
        $this->assertSortItemNotEmpty($item);

        // In this implementation, a requested sorting item must have the
        // following format: "property [direction]". Thus, whitespace acts
        // as a delimiter. Overwrite this method, if a different "split"
        // is desired...
        return explode(' ', $item);
    }

    /**
     * Extracts list of properties with sorting direction, from given
     * requested value
     *
     * @param string $value
     * @param string $delimiter
     *
     * @return string[]
     */
    protected function extractListFromRequested(string $value, string $delimiter): array
    {
        return array_map(function ($item) {
            return trim($item);
        }, explode($delimiter, $value));
    }

    /**
     * Resolves the sql sorting direction token from given identifier
     *
     * @param string $identifier
     *
     * @return string
     *
     * @throws InvalidParameter If identifier is not supported or known
     */
    protected function resolveSqlSortingDirection(string $identifier): string
    {
        if (isset($this->directions[$identifier])) {
            return $this->directions[$identifier];
        }

        throw InvalidParameter::make($this, sprintf(
            '%s is not a valid sorting direction. Allowed values are %s',
            $identifier,
            implode(', ', array_keys($this->directions))
        ));
    }

    /**
     * Assert that requested sortable properties does not exceed
     * the maximum supported amount
     *
     * @param array $value
     *
     * @throws InvalidParameter
     */
    protected function assertNotTooManyPropertiesToSortBy(array $value)
    {
        if (count($value) > $this->maxSortingProperties) {
            throw InvalidParameter::make($this, trans('validation.max.array', [
                'attribute' => $this->parameter(),
                'max' => $this->maxSortingProperties
            ]));
        }
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
            throw InvalidParameter::make(
                $this,
                sprintf('%s is not supported as a sortable property', $property)
            );
        }

        return $this;
    }

    /**
     * Assert that given sort item is not empty
     *
     * @param string $item
     *
     * @throws InvalidParameter
     */
    protected function assertSortItemNotEmpty(string $item)
    {
        if (empty($item)) {
            throw InvalidParameter::make($this, sprintf('%s value contains empty items.', $this->parameter()));
        }
    }
}
