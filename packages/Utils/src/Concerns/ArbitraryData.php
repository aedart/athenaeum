<?php

namespace Aedart\Utils\Concerns;

use Aedart\Utils\Arr;

/**
 * Concerns Arbitrary Data
 *
 * @see \Aedart\Contracts\Utils\HasArbitraryData
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils\Concerns
 */
trait ArbitraryData
{
    /**
     * The key-value store
     *
     * @var array
     */
    protected array $arbitraryDataStore = [];

    /**
     * Set a value for given key
     *
     * @param  string|int  $key
     * @param  mixed  $value
     *
     * @return self
     */
    public function set(int|string $key, mixed $value): static
    {
        Arr::set($this->arbitraryDataStore, $key, $value);

        return $this;
    }

    /**
     * Get value for given key
     *
     * @param  string|int  $key
     * @param  mixed $default  [optional]
     *
     * @return mixed
     */
    public function get(int|string $key, mixed $default = null): mixed
    {
        return Arr::get($this->arbitraryDataStore, $key, $default);
    }

    /**
     * Determine if value exists for key
     *
     * @param  string|int  $key
     *
     * @return bool
     */
    public function has(int|string $key): bool
    {
        return Arr::has($this->arbitraryDataStore, $key);
    }

    /**
     * Delete key and its value
     *
     * @param  string|int  $key
     *
     * @return bool
     */
    public function forget(int|string $key): bool
    {
        if ($this->has($key)) {
            Arr::forget($this->arbitraryDataStore, $key);
            return true;
        }

        return false;
    }

    /**
     * Alias for {@see forget()}
     *
     * @param  string|int  $key
     *
     * @return bool
     */
    public function delete(int|string $key): bool
    {
        return $this->forget($key);
    }

    /**
     * Removes all arbitrary data from this component
     *
     * @return bool
     */
    public function clear(): bool
    {
        $this->arbitraryDataStore = [];

        return true;
    }

    /**
     * Returns all values associated with this resource
     *
     * @return array
     */
    public function all(): array
    {
        return $this->arbitraryDataStore;
    }

    /**
     * Determine if component has items
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->arbitraryDataStore);
    }

    /**
     * Determine if component has no items
     *
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return !empty($this->arbitraryDataStore);
    }

    /**
     * Determine if key exists
     *
     * @param  mixed  $offset
     *
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    /**
     * Get value for key
     *
     * @param  mixed  $offset
     *
     * @return mixed
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    /**
     * Set a value for given key
     *
     * @param  mixed  $offset
     * @param  mixed  $value
     *
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    /**
     * Delete key and its value
     *
     * @param  mixed  $offset
     *
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->forget($offset);
    }
}