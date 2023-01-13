<?php

namespace Aedart\Contracts\Utils;

use ArrayAccess;

/**
 * Has Arbitrary Data
 *
 * Component is able to set and obtain arbitrary data for a given key.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Utils
 */
interface HasArbitraryData extends ArrayAccess
{
    /**
     * Set a value for given key
     *
     * @param  string|int  $key
     * @param  mixed  $value
     *
     * @return self
     */
    public function set(string|int $key, mixed $value): static;

    /**
     * Get value for given key
     *
     * @param  string|int  $key
     * @param  mixed $default  [optional]
     *
     * @return mixed
     */
    public function get(string|int $key, mixed $default = null): mixed;

    /**
     * Determine if value exists for key
     *
     * @param  string|int  $key
     *
     * @return bool
     */
    public function has(string|int $key): bool;

    /**
     * Delete key and its value
     *
     * @param  string|int  $key
     *
     * @return bool
     */
    public function forget(string|int $key): bool;

    /**
     * Alias for {@see forget()}
     *
     * @param  string|int  $key
     *
     * @return bool
     */
    public function delete(string|int $key): bool;

    /**
     * Removes all arbitrary data from this component
     *
     * @return bool
     */
    public function clear(): bool;

    /**
     * Returns all values associated with this resource
     *
     * @return array
     */
    public function all(): array;

    /**
     * Determine if component has items
     *
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Determine if component has no items
     *
     * @return bool
     */
    public function isNotEmpty(): bool;
}