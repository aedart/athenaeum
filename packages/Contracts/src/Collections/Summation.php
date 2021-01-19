<?php

namespace Aedart\Contracts\Collections;

use Aedart\Contracts\Collections\Exceptions\SummationException;
use Aedart\Contracts\Collections\Summations\ProcessingRule;
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
 * TODO: A brief description of what this is...
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
     * Make new Summation based on given items and processing
     * rules without processing them items
     *
     * @see build
     * @see process
     *
     * @param array|Traversable $items
     * @param  string[]|ProcessingRule[]  $rules  [optional] List of class paths to Processing Rule
     *                                             or list Processing Rule instances
     *
     * @return static
     *
     *
     * @throws SummationException
     */
    public function make($items, array $rules = []): Summation;

    /**
     * Make new Summation based on given items and processing
     * rules and process the items
     *
     * @see process
     *
     * @param array|Traversable $items
     * @param  string[]|ProcessingRule[]  $rules  [optional] List of class paths to Processing Rule
     *                                             or list Processing Rule instances
     *
     * @return static
     *
     * @throws SummationException
     */
    public static function build($items, array $rules = []): Summation;

    /**
     * Applies processing rules on items and builds
     * this summation's result
     *
     * @return self
     *
     * @throws SummationException
     */
    public function process(): self;

    public function with($items, array $rules = []): self;

    /**
     * Merge items into this summation
     *
     * @param array|Traversable $items
     *
     * @return self
     */
    public function withItems($items): self;

    /**
     * Set this summation's items
     *
     * Eventual existing items are overwritten
     *
     * @param array|Traversable $items
     *
     * @return self
     */
    public function setItems($items): self;

    /**
     * Returns the items that form the basis for
     * this summation
     *
     * @return array|Traversable
     */
    public function items();

    public function withRules(array $rules = []): self;

    public function setRules(array $rules = []): self;

    /**
     * Returns the processing rules
     *
     * @return ProcessingRule[]
     */
    public function rules(): array;

    /**
     * Set the value for a given key
     *
     * @param  string  $key
     * @param mixed $value
     *
     * @return self
     */
    public function set(string $key, $value): self;

    /**
     * Get the value for given key
     *
     * @param  string  $key
     * @param  mixed|null  $default  [optional] Default value to return if key
     *                               does not exist
     *
     * @return mixed
     */
    public function get(string $key, $default = null);

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

    public function increase(string $key, $amount = 1): self;

    public function decrease(string $key, $amount = 1): self;

    public function add(string $key, $amount): self;

    public function subtract(string $key, $amount): self;

    public function multiply(string $key, $amount): self;

    public function divide(string $key, $amount): self;

    public function sum();

    public function average();

    public function avg();

    public function min();

    public function max();
}
