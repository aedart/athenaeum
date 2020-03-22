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
     * @inheritdoc
     */
    public function withQuery(array $query): Builder
    {
        return $this->setQuery(
            array_merge($this->getQuery(), $query)
        );
    }

    /**
     * @inheritdoc
     */
    public function setQuery(array $query): Builder
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function hasQuery(): bool
    {
        return !empty($this->query);
    }

    /**
     * @inheritdoc
     */
    public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * @inheritdoc
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
