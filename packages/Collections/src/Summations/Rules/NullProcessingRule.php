<?php

namespace Aedart\Collections\Summations\Rules;

use Aedart\Contracts\Collections\Summation;
use Aedart\Contracts\Collections\Summations\Rules\ProcessingRule;

/**
 * Null Processing Rule
 *
 * Intended for testing or situation when a processing rule is
 * required, yet not intended to do anything.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Collections\Summations\Rules
 */
class NullProcessingRule implements ProcessingRule
{
    /**
     * @inheritDoc
     */
    public function process(mixed $item, Summation $summation): Summation
    {
        return $summation;
    }
}
