<?php

namespace Aedart\Contracts\Filters;

use Aedart\Contracts\Database\Query\Criteria;

/**
 * Built Filters Map
 *
 * Map of http query parameters and corresponding query filters that
 * must be applied on a database query.
 *
 * The map also offers the ability to store and retrieve additional
 * "meta" data associated with http query parameters or query filters.
 *
 * @see Criteria
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Filters
 */
interface BuiltFiltersMap
{
    /**
     * Add a built filter for given key
     *
     * @param string $key
     * @param Criteria $filter
     *
     * @retrun self
     */
    public function add(string $key, Criteria $filter): static;

    /**
     * Get built filters that match given key
     *
     * @param string $key
     * @param Criteria[] $default [optional]
     *
     * @return Criteria[]
     */
    public function get(string $key, array $default = []): array;

    /**
     * Determine if filters exist for given key
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Forget all filters for the given key
     *
     * @param string $key
     *
     * @return self
     */
    public function forget(string $key): static;

    /**
     * Get all built filters
     *
     * @return Criteria[]
     */
    public function all(): array;

    /**
     * Set arbitrary meta data for given key
     *
     * @param string $key
     * @param mixed $meta
     *
     * @return self
     */
    public function setMeta(string $key, mixed $meta): static;

    /**
     * Get arbitrary meta data for given key
     *
     * @param string $key
     * @param mixed $default [optional]
     *
     * @return mixed
     */
    public function getMeta(string $key, mixed $default = null): mixed;

    /**
     * Determine if arbitrary meta data exists for given key
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasMeta(string $key): bool;

    /**
     * Forget meta for given key
     *
     * @param string $key
     *
     * @return self
     */
    public function forgetMeta(string $key): static;

    /**
     * Get all arbitrary meta data
     *
     * @return array Key-value
     */
    public function meta(): array;

    /**
     * Clears the map of all filters and meta
     *
     * @return self
     */
    public function forgetAll(): static;
}
