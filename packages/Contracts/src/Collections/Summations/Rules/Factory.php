<?php

namespace Aedart\Contracts\Collections\Summations\Rules;

use Aedart\Contracts\Collections\Exceptions\SummationCollectionException;
use Aedart\Contracts\Collections\Summation;

/**
 * Summation Rules Collection Factory
 *
 * Responsible for determining processing rules to use for
 * an item and create a matching collection with appropriate
 * rules.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Collections\Summations\Rules
 */
interface Factory
{
    /**
     * Creates a collection of processing rules to process
     * given item.
     *
     * @param mixed $item
     * @param  Summation  $summation
     *
     * @return Rules
     *
     * @throws SummationCollectionException
     */
    public function make($item, Summation $summation): Rules;
}
