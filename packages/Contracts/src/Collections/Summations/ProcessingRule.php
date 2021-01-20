<?php

namespace Aedart\Contracts\Collections\Summations;

use Aedart\Contracts\Collections\Summation;

/**
 * Summation Item Processing Rule
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Collections\Summations
 */
interface ProcessingRule
{
    /**
     * Process given item and return the resulting summation
     *
     * Method is responsible for adding or manipulating values
     * in the Summation instance, if deemed appropriate.
     *
     * @see isApplicable
     *
     * @param mixed $item
     *
     * @return Summation Summation with results from processing or
     *                   unchanged Summation if rule was not applicable
     */
    public function process($item): Summation;

    /**
     * Returns the summation assigned for this
     * processing rule
     *
     * @return Summation
     */
    public function summation(): Summation;
}
