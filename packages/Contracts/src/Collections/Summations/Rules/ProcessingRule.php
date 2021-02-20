<?php

namespace Aedart\Contracts\Collections\Summations\Rules;

use Aedart\Contracts\Collections\Exceptions\SummationCollectionException;
use Aedart\Contracts\Collections\Summation;

/**
 * Summation Item Processing Rule
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Collections\Summations\Rules
 */
interface ProcessingRule
{
    /**
     * Process item and return the resulting summation
     *
     * Method is responsible for adding or manipulating values
     * in the Summation instance, if deemed appropriate.
     *
     * @param mixed $item The item in question
     * @param Summation $summation The Summation Collection instance
     *
     * @return Summation Summation with results from having processed
     *                   the assigned item
     *
     * @throws SummationCollectionException
     */
    public function process($item, Summation $summation): Summation;
}
