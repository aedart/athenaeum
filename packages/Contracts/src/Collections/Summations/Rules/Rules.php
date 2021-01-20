<?php

namespace Aedart\Contracts\Collections\Summations\Rules;

use Aedart\Contracts\Collections\Exceptions\SummationException;
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
     * @throws SummationException
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
     * Returns the item to be processed by this
     * collection's processing rules
     *
     * @return mixed
     */
    public function item();

    /**
     * Returns the summation assigned for this
     * collection of processing rules
     *
     * @return Summation
     */
    public function summation(): Summation;
}
