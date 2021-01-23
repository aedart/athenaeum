<?php

namespace Aedart\Contracts\Collections\Summations;

use Aedart\Contracts\Collections\Exceptions\SummationCollectionException;
use Aedart\Contracts\Collections\Summation;
use Aedart\Contracts\Collections\Summations\Rules\Factory as ProcessingRulesFactory;
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
     * Process given items, by using processing rules created from
     * given factory.
     *
     * @param  array|Traversable  $items
     * @param  ProcessingRulesFactory  $factory
     * @param  Summation|null  $summation  [optional] If none given, then a new Summation instance
     *                                     will be created.
     *
     * @return Summation
     *
     * @throws SummationCollectionException
     */
    public static function process($items, ProcessingRulesFactory $factory, ?Summation $summation = null): Summation;
}
