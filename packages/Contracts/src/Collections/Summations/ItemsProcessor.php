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
     * @param  array|Traversable  $items List of items to be processed
     * @param  ProcessingRule[]|string[]|Repository  $rules Processing Rules instances, class paths or Repository of
     *                                                processing rules.
     * @param  Summation|null  $summation [optional] Summation instance to be passed on to processing rules.
     *                                    If none given, then a new Summation instance
     *                                    will be created.
     *
     * @return Summation
     *
     * @throws SummationCollectionException
     */
    public function process($items, $rules, ?Summation $summation = null): Summation;
}
