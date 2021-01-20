<?php

namespace Aedart\Contracts\Collections\Summations\Rules;

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
     * @return Summation Summation with results from having processed
     *                   the assigned item
     */
    public function process(): Summation;

    /**
     * Returns the item to be processed
     *
     * @return mixed
     */
    public function item();

    /**
     * Returns the summation assigned for this
     * processing rule
     *
     * @return Summation
     */
    public function summation(): Summation;
}
