<?php

namespace Aedart\Contracts\Streams\Meta;

use ArrayAccess;

/**
 * Stream Meta Repository
 *
 * A key-value repository of arbitrary data associated with a stream.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Streams
 */
interface Repository extends ArrayAccess
{
    /**
     * Set meta value
     *
     * @param  string  $key
     * @param  mixed  $value
     *
     * @return self
     */
    public function set(string $key, mixed $value): static;

    /**
     * Get meta value
     *
     * @param  string  $key
     * @param  mixed|null  $default  [optional]
     *
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Determine has meta value
     *
     * @param  string  $key
     *
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Remove meta value
     *
     * @param  string  $key
     *
     * @return bool
     */
    public function remove(string $key): bool;

    /**
     * Merge new meta into this repository
     *
     * @param  array  $meta
     *
     * @return self
     */
    public function merge(array $meta): static;

    /**
     * Get all meta values
     *
     * @return array
     */
    public function all(): array;
}
