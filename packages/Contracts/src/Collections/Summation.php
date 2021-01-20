<?php

namespace Aedart\Contracts\Collections;

use Aedart\Contracts\Collections\Exceptions\SummationException;
use Aedart\Contracts\Collections\Summations\ProcessingRule;
use Aedart\Contracts\Collections\Summations\Rules\Factory as ProcessingRulesFactory;
use ArrayAccess;
use Countable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use IteratorAggregate;
use JsonSerializable;
use Traversable;

/**
 * Summation Collection
 *
 * A collection of results based on the processing of items according
 * to various processing rules.
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
    Jsonable
{
    /**
     * Creates new Summation instance with given items and processing
     * rules factory
     *
     * @param array|Traversable $items
     * @param  ProcessingRulesFactory  $factory
     *
     * @return static
     *
     * @throws SummationException
     */
    public function make($items, ProcessingRulesFactory $factory): Summation;

    /**
     * Creates new Summation instance with given items and processing
     * rules factory. Once instance is created, method will process
     * all items according to the resulting processing rules
     *
     * @param array|Traversable $items
     * @param  ProcessingRulesFactory  $factory
     *
     * @return static
     */
    public static function build($items, ProcessingRulesFactory $factory): Summation;

    /**
     * Applies processing rules on items and builds
     * this summation's result
     *
     * @return self
     *
     * @throws SummationException
     */
    public function process(): self;

    /**
     * Returns the items that form the basis for
     * this Summation's results
     *
     * @return array|Traversable
     */
    public function items();

    /**
     * Set the value for a given key
     *
     * @param  string  $key
     * @param mixed $value If callback is provided, then it is invoked
     *                     with key's original value and this Summation
     *                     instance as arguments. The resulting output is
     *                     set as key's new value.
     *
     * @return self
     */
    public function set(string $key, $value): self;

    /**
     * Get the value for given key
     *
     * @param  string  $key
     * @param  mixed|null  $default  [optional] Default value to return if key
     *                               does not exist. Can also be a callback.
     *
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * Alias for {@see add}
     *
     * @param  string  $key
     * @param int|float|callable $amount [optional] If amount is a callback, then
     *                      callback is invoked with key's value and this
     *                      Summation as arguments. The resulting output is
     *                      set as key's new value.
     *
     * @return self
     *
     * @throws SummationException If key does not exist, if value is not numeric,
     *                            or invalid amount argument
     */
    public function increase(string $key, $amount = 1): self;

    /**
     * Alias for {@see subtract}
     *
     * @param  string  $key
     * @param int|float|callable $amount [optional] If amount is a callback, then
     *                      callback is invoked with key's value and this
     *                      Summation as arguments. The resulting output is
     *                      set as key's new value.
     *
     * @return self
     *
     * @throws SummationException If key does not exist, if value is not numeric,
     *                            or invalid amount argument
     */
    public function decrease(string $key, $amount = 1): self;

    /**
     * Add amount to key's value
     *
     * @param  string  $key
     * @param int|float|callable $amount If amount is a callback, then
     *                      callback is invoked with key's value and this
     *                      Summation as arguments. The resulting output is
     *                      set as key's new value.
     *
     * @return self
     *
     * @throws SummationException If key does not exist, if value is not numeric,
     *                            or invalid amount argument
     */
    public function add(string $key, $amount): self;

    /**
     * Subtract amount from key's value
     *
     * @param  string  $key
     * @param int|float|callable $amount If amount is a callback, then
     *                      callback is invoked with key's value and this
     *                      Summation as arguments. The resulting output is
     *                      set as key's new value.
     *
     * @return self
     *
     * @throws SummationException If key does not exist, if value is not numeric,
     *                            or invalid amount argument
     */
    public function subtract(string $key, $amount): self;

    /**
     * Multiply a key's value by given amount
     *
     * @param  string  $key
     * @param int|float|callable $amount If amount is a callback, then
     *                      callback is invoked with key's value and this
     *                      Summation as arguments. The resulting output is
     *                      set as key's new value.
     *
     * @return self
     *
     * @throws SummationException If key does not exist, if value is not numeric,
     *                            or invalid amount argument
     */
    public function multiply(string $key, $amount): self;

    /**
     * Divide a key's value by given amount
     *
     * @param  string  $key
     * @param int|float|callable $amount If amount is a callback, then
     *                      callback is invoked with key's value and this
     *                      Summation as arguments. The resulting output is
     *                      set as key's new value.
     *
     * @return self
     *
     * @throws SummationException If key does not exist, if value is not numeric,
     *                            or invalid amount argument
     */
    public function divide(string $key, $amount): self;

    /**
     * Apply a callback on key's value.
     *
     * If the key does not exist, then it is added.
     *
     * @param  string  $key
     * @param  callable  $callback Callback is given original's value and this
     *                             Summation instance as arguments. The resulting output is
     *                             set as key's new value.
     *
     * @return self
     */
    public function apply(string $key, callable $callback): self;

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
    public function isEmpty(string $key): bool;

    /**
     * Determine if key exists and if it's value is not empty (e.g. not zero)
     *
     * @param  string  $key
     *
     * @return bool
     */
    public function isNotEmpty(string $key): bool;

    /**
     * Remove a key and it's value
     *
     * @param  string  $key
     *
     * @return bool True if key was removed, false if key didn't
     *              exist
     */
    public function remove(string $key): bool;
}
