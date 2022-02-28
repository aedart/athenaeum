<?php

namespace Aedart\Contracts\Streams;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use ArrayAccess;

/**
 * Stream Meta
 *
 * A key-value store of arbitrary data associated with a stream.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Streams
 */
interface Meta extends ArrayAccess
{
    /**
     * Creates a new stream meta store with given metadata
     *
     * @param  array  $meta  [optional] Key-value store
     *
     * @return static
     */
    public static function make(array $meta = []): static;

    /**
     * Creates a new stream meta store for given stream
     *
     * Method attempts to obtain stream metadata using PHP's
     * builtin {@see stream_get_meta_data()} method.
     *
     * @param resource|Stream $stream
     *
     * @return static
     *
     * @throws StreamException
     */
    public static function makeFor($stream): static;

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
     * @param  bool  $preserveKey  [optional]
     *
     * @return bool
     */
    public function remove(string $key, bool $preserveKey = false): bool;

    /**
     * Get all meta values
     *
     * @return array
     */
    public function all(): array;
}
