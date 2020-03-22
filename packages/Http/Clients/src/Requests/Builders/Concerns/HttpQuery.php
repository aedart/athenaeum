<?php

namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Requests\Builder;

/**
 * Concerns Http Query
 *
 * @see Builder
 * @see Builder::withQuery
 * @see Builder::setQuery
 * @see Builder::hasQuery
 * @see Builder::getQuery
 * @see Builder::where
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Concerns
 */
trait HttpQuery
{
    /**
     * Http query string values
     *
     * @var array Key-value pairs
     */
    protected array $query = [];

    /**
     * Add query string values to the next request
     *
     * Method merges given values with existing.
     *
     * NOTE: When this method used, evt. query string
     * applied on the Uri is ignored.
     *
     * @see setQuery
     * @see https://en.wikipedia.org/wiki/Query_string
     *
     * @param array $query Key-value pair
     *
     * @return self
     */
    public function withQuery(array $query): Builder
    {
        return $this->setQuery(
            array_merge($this->getQuery(), $query)
        );
    }

    /**
     * Set the Http query string for the next request
     *
     * Method will overwrite existing query.
     *
     * NOTE: When this method used, evt. query string
     * applied on the Uri is ignored.
     *
     * @see https://en.wikipedia.org/wiki/Query_string
     *
     * @param array $query Key-value pair
     *
     * @return self
     */
    public function setQuery(array $query): Builder
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Determine if Http query string values have been set
     * for the next request
     *
     * @return bool
     */
    public function hasQuery(): bool
    {
        return !empty($this->query);
    }

    /**
     * Get the Http query string values for the next
     * request
     *
     * @return array Key-value pairs
     */
    public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * Add a Http query value, for the given field
     *
     * Method attempts to merge field values recursively, with
     * existing query values.
     *
     * When only two arguments are provided, the second argument
     * acts as the value, and the last argument is omitted.
     *
     * When all three arguments are provided, the second arguments
     * acts either as a "sparse field type" identifier, as described
     * by Json API v1.x.
     *
     * If the first argument is a list of fields with values, then
     * both `$type` and `$value` arguments are ignored.
     *
     * @see setQuery
     * @see withQuery
     * @see https://en.wikipedia.org/wiki/Query_string
     * @see https://jsonapi.org/format/#fetching-sparse-fieldsets
     *
     * @param string|array $field Field name or List of fields with values
     * @param mixed $type [optional] Sparse fieldset identifier (string) or field value
     * @param mixed $value [optional] Field value. Only used if `$type` argument is provided
     *
     * @return self
     */
    public function where($field, $type = null, $value = null): Builder
    {
        // When list of fields => values is given.
        if (is_array($field)) {
            return $this->addQueryFieldsWithValues($field);
        }

        // Prepare the value to be used. We assume that only two arguments are
        // provided, at this point. This means that the "type" argument acts as
        // the field's value.
        $appliedValue = $type;

        // When all arguments are provided, then we change the structure of the
        // applied value, to match that of "Sparse Fieldset", as described by
        // Json Api v1.x.
        if (func_num_args() === 3) {
            $appliedValue = [ $type => $value ];
        }

        // Prepare the "query" field and value to be added.
        $query = [ $field => $appliedValue];

        // Merge the query recursively, with the existing query values.
        // This allows multiple calls to the same field to be performed.
        return $this->setQuery(
            array_merge_recursive($this->getQuery(), $query)
        );
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Add multiple Http query values for list of fields
     *
     * @see where
     *
     * @param array $fields
     *
     * @return self
     */
    protected function addQueryFieldsWithValues(array $fields): Builder
    {
        foreach ($fields as $field => $value) {
            $this->where($field, $value);
        }

        return $this;
    }
}
