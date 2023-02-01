<?php

namespace Aedart\Contracts\ETags\Preconditions\Ranges;

use Ramsey\Http\Range\Unit\UnitRangeInterface;

/**
 * Range-Set
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\ETags\Preconditions\Ranges
 */
interface RangeSet extends UnitRangeInterface
{
    /**
     * Returns the unit token defined for this unit.
     *
     * @return string E.g. bytes
     */
    public function unit(): string;
}
