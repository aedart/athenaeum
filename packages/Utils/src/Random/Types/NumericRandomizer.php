<?php

namespace Aedart\Utils\Random\Types;

use Aedart\Contracts\Utils\Random\NumericRandomizer as NumericRandomizerInterface;

/**
 * Numeric Randomizer
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Utils\Random\Types
 */
class NumericRandomizer extends BaseRandomizer implements NumericRandomizerInterface
{
    /**
     * @inheritDoc
     */
    public function int(int $min, int $max): int
    {
        return $this->driver()->getInt($min, $max);
    }

    /**
     * @inheritDoc
     */
    public function nextInt(): int
    {
        return $this->driver()->nextInt();
    }
}
