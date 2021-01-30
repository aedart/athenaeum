<?php

namespace Aedart\Contracts\Collections\Summations\Rules;

use Aedart\Contracts\Collections\Exceptions\SummationCollectionException;
use Aedart\Contracts\Collections\Summation;
use Countable;
use Illuminate\Contracts\Support\Arrayable;
use IteratorAggregate;

/**
 * Summation Processing Rules Collection
 *
 * An immutable collection of processing rules for assigned item.
 *
 * @see ProcessingRule
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Collections\Summations\Rules
 */
interface Rules extends
    Countable,
    Arrayable,
    IteratorAggregate
{
    /**
     * Process item and return the resulting summation
     *
     * Method invokes all assigned processing rules
     *
     * @return Summation Summation with results from having processed
     *                   the assigned item
     *
     * @throws SummationCollectionException
     */
    public function process(): Summation;

    /**
     * Returns this collection's assigned processing
     * rules
     *
     * @return ProcessingRule[]
     */
    public function rules(): array;

    /**
     * Creates a new collection with given processing rules
     *
     * @param  ProcessingRule[]  $rules
     *
     * @return static
     */
    public function withRules(array $rules): Rules;

    /**
     * Returns the item to be processed by this
     * collection's processing rules
     *
     * @return mixed
     */
    public function item();

    /**
     * Creates a new collection with given item.
     *
     * @param mixed $item
     *
     * @return static
     */
    public function withItem($item): Rules;

    /**
     * Returns the summation assigned for this
     * collection of processing rules
     *
     * @return Summation|null
     */
    public function summation(): ?Summation;

    /**
     * Creates a new collection with given summation
     *
     * @param  Summation  $summation
     *
     * @return static
     */
    public function withSummation(Summation $summation): Rules;
}
