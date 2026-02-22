<?php

namespace Aedart\Contracts\Collections;

use Aedart\Contracts\Collections\Exceptions\SummationCollectionException;
use Aedart\Contracts\Collections\Summations\ItemsProcessor;
use ArrayAccess;
use Countable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use IteratorAggregate;
use JsonSerializable;
use Stringable;

/**
 * Summation Collection
 *
 * A collection of results, which typically are a product of
 * processing multiple items, e.g. database records.
 *
 * @see ItemsProcessor
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Collections
 */
interface Summation extends
    Countable,
    IteratorAggregate,
    ArrayAccess,
    Arrayable,
    JsonSerializable,
    Jsonable,
    Stringable
{
    /**
     * Creates new Summation instance with given results
     *
     * @param Arrayable|iterable $results  [optional]
     *
     * @return static
     *
     * @throws SummationCollectionException
     */
    public static function make(Arrayable|iterable $results = []): static;

    /**
     * Set the value for a given key
     *
     * @param  string  $key
     * @param mixed|callable(mixed $value, static $summation): mixed $value If callback is provided, then it is invoked
     *                     with key's original value and this Summation
     *                     instance as arguments. The resulting output is
     *                     set as key's new value.
     *
     * @return self
     */
    public function set(string $key, mixed $value): static;

    /**
     * Get the value for given key
     *
     * @param  string  $key
     * @param  mixed|null  $default  [optional] Default value to return if key
     *                               does not exist. Can also be a callback.
     *
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Alias for {@see add}
     *
     * @param  string  $key
     * @param  float|int|callable(mixed $value, static $summation): mixed  $amount [optional] If amount is a callback, then
     *                      callback is invoked with key's value and this
     *                      Summation as arguments. The resulting output is
     *                      set as key's new value.
     *
     * @return self
     *
     * @throws SummationCollectionException If key does not exist
     */
    public function increase(string $key, callable|float|int $amount = 1): static;

    /**
     * Alias for {@see subtract}
     *
     * @param  string  $key
     * @param  float|int|callable(mixed $value, static $summation): mixed  $amount [optional] If amount is a callback, then
     *                      callback is invoked with key's value and this
     *                      Summation as arguments. The resulting output is
     *                      set as key's new value.
     *
     * @return self
     *
     * @throws SummationCollectionException If key does not exist
     */
    public function decrease(string $key, callable|float|int $amount = 1): static;

    /**
     * Add amount to key's value
     *
     * @param  string  $key
     * @param  float|int|callable(mixed $value, static $summation): mixed  $amount If amount is a callback, then
     *                      callback is invoked with key's value and this
     *                      Summation as arguments. The resulting output is
     *                      set as key's new value.
     *
     * @return self
     *
     * @throws SummationCollectionException If key does not exist
     */
    public function add(string $key, callable|float|int $amount): static;

    /**
     * Subtract amount from key's value
     *
     * @param  string  $key
     * @param  float|int|callable(mixed $value, static $summation): mixed  $amount If amount is a callback, then
     *                      callback is invoked with key's value and this
     *                      Summation as arguments. The resulting output is
     *                      set as key's new value.
     *
     * @return self
     *
     * @throws SummationCollectionException If key does not exist
     */
    public function subtract(string $key, callable|float|int $amount): static;

    /**
     * Multiply a key's value by given amount
     *
     * @param  string  $key
     * @param  float|int|callable(mixed $value, static $summation): mixed  $amount If amount is a callback, then
     *                      callback is invoked with key's value and this
     *                      Summation as arguments. The resulting output is
     *                      set as key's new value.
     *
     * @return self
     *
     * @throws SummationCollectionException If key does not exist
     */
    public function multiply(string $key, callable|float|int $amount): static;

    /**
     * Divide a key's value by given amount
     *
     * @param  string  $key
     * @param  float|int|callable(mixed $value, static $summation): mixed  $amount If amount is a callback, then
     *                      callback is invoked with key's value and this
     *                      Summation as arguments. The resulting output is
     *                      set as key's new value.
     *
     * @return self
     *
     * @throws SummationCollectionException If key does not exist
     */
    public function divide(string $key, callable|float|int $amount): static;

    /**
     * Apply a callback on key's value.
     *
     * If the key does not exist, then it is added.
     *
     * @param  string  $key
     * @param  callable(mixed $value, static $summation): mixed  $callback Callback is given original's value and this
     *                             Summation instance as arguments. The resulting output is
     *                             set as key's new value.
     *
     * @return self
     */
    public function apply(string $key, callable $callback): static;

    /**
     * Determine is key exists
     *
     * @param  string  $key
     *
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Determine if key exists and if it's value is empty (e.g. zero)
     *
     * @param  string  $key
     *
     * @return bool
     */
    public function hasValue(string $key): bool;

    /**
     * Determine if key exists and if it's value is not empty (e.g. not zero)
     *
     * @param  string  $key
     *
     * @return bool
     */
    public function hasNoValue(string $key): bool;

    /**
     * Determine if collection is empty or not
     *
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Determine if collection is not empty
     *
     * @return bool
     */
    public function isNotEmpty(): bool;

    /**
     * Remove a key and it's value
     *
     * @param  string  $key
     *
     * @return bool True if key was removed, false if key didn't
     *              exist
     */
    public function remove(string $key): bool;

    /**
     * Dumps collection and stops script
     * from further execution
     */
    public function dd(): never;

    /**
     * Dumps collection
     *
     * @return self
     */
    public function dump(): static;
}
