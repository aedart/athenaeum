<?php

namespace Aedart\Collections\Summations\Rules;

use Aedart\Contracts\Collections\Summation;

/**
 * Null Processing Rule
 *
 * Intended for testing or situation when a processing rule is
 * required, yet not intended to do anything.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Collections\Summations\Rules
 */
class NullProcessingRule extends BaseProcessingRule
{
    /**
     * @inheritDoc
     */
    public function process(): Summation
    {
        return $this->summation();
    }
}
