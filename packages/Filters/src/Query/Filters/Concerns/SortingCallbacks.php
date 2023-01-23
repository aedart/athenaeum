<?php

namespace Aedart\Filters\Query\Filters\Concerns;

/**
 * Concerns Sorting Callbacks
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Filters\Query\Filters\Concerns
 */
trait SortingCallbacks
{
    /**
     * List of sorting callbacks to be applied
     *
     * @var callable[] Key-value pair, key = database table column, value = sorting callback
     */
    protected array $sortingCallbacks = [];

    /**
     * Add sorting callbacks for database columns
     *
     * @param callable[] $callbacks Key-value pair, key = database table column, value = sorting callback
     *
     * @return self
     */
    public function withSortingCallbacks(array $callbacks): static
    {
        foreach ($callbacks as $column => $callback) {
            $this->withSortingCallback($column, $callback);
        }

        return $this;
    }

    /**
     * Add sorting callback for given database column
     *
     * @param string $column
     * @param callable $callback Sorting callback
     *
     * @return self
     */
    public function withSortingCallback(string $column, callable $callback): static
    {
        $this->sortingCallbacks[$column] = $callback;

        return $this;
    }

    /**
     * Get the sorting callbacks
     *
     * @return callable[] Key-value pair, key = database table column, value = sorting callback
     */
    public function getSortingCallbacks(): array
    {
        return $this->sortingCallbacks;
    }

    /**
     * Clear sorting callbacks
     *
     * @return self
     */
    public function clearSortingCallbacks(): static
    {
        $this->sortingCallbacks = [];

        return $this;
    }
}
