<?php

namespace Aedart\Utils\Random\Types;

use Aedart\Contracts\Utils\Random\NumericRandomizer as NumericRandomizerInterface;
use Random\IntervalBoundary;

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

    /**
     * @inheritdoc
     */
    public function float(float $min, float $max, IntervalBoundary $boundary = IntervalBoundary::ClosedOpen): float
    {
        return $this->driver()->getFloat($min, $max, $boundary);
    }

    /**
     * @inheritdoc
     */
    public function nextFloat(): float
    {
        return $this->driver()->nextFloat();
    }
}
