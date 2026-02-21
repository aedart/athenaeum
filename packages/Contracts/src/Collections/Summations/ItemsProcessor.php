<?php

namespace Aedart\Contracts\Collections\Summations;

use Aedart\Contracts\Collections\Exceptions\SummationCollectionException;
use Aedart\Contracts\Collections\Summation;
use Aedart\Contracts\Collections\Summations\Rules\ProcessingRule;
use Aedart\Contracts\Collections\Summations\Rules\Repository;
use Traversable;

/**
 * Summation Items Processor
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Collections\Summations
 */
interface ItemsProcessor
{
    /**
     * Process given items and return resulting summation collection
     *
     * Method invokes the {@link before} and {@link after} callbacks, if available.
     *
     * @see before
     * @see after
     *
     * @param  array|Traversable  $items List of items to be processed
     *
     * @return Summation
     *
     * @throws SummationCollectionException
     */
    public function process(array|Traversable $items): Summation;

    /**
     * Apply a callback onto the Summation Collection, before
     * items are processed.
     *
     * @param  callable(Summation): (Summation)|null  $callback  [optional] Summation Collection is given
     *                                   as argument to callback, when invoked.
     *                                   Callback MUST return a Summation Collection!
     *
     * @return self
     */
    public function before(callable|null $callback = null): static;

    /**
     * Apply a callback onto the Summation Collection, before
     * items are processed.
     *
     * @param  callable(Summation): (Summation)|null  $callback  [optional] Summation Collection is given
     *                                   as argument to callback, when invoked.
     *                                   Callback MUST return a Summation Collection!
     *
     * @return self
     */
    public function after(callable|null $callback = null): static;

    /**
     * Returns a Repository of Processing Rules
     *
     * @return Repository
     */
    public function rules(): Repository;

    /**
     * Creates a new items' processor with given processing rules
     *
     * @param  array<ProcessingRule|Repository|class-string<Repository>>  $rules
     *
     * @return static
     */
    public function withRules(array|Repository $rules): static;

    /**
     * Returns the summation collection to be passed
     * on to each processing rule
     *
     * @return Summation
     */
    public function summation(): Summation;

    /**
     * Creates a new items' processor with given summation collection
     *
     * @param  Summation  $summation
     *
     * @return static
     */
    public function withSummation(Summation $summation): static;
}
