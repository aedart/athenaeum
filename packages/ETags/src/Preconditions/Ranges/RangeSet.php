<?php

namespace Aedart\ETags\Preconditions\Ranges;

use Aedart\Contracts\ETags\Preconditions\Ranges\RangeSet as RangeSetInterface;
use Ramsey\Http\Range\Unit\UnitRangeInterface;

/**
 * Range-Set
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions\Ranges
 */
class RangeSet implements RangeSetInterface
{
    /**
     * Creates a new range-set instance
     *
     * @param string $unit
     * @param string $range
     * @param int $start
     * @param int $end
     * @param mixed $totalSize
     */
    public function __construct(
        protected string $unit,
        protected string $range,
        protected int $start,
        protected int $end,
        protected mixed $totalSize
    ) {
    }

    /**
     * Creates a new instance from given unit-range instance
     *
     * @param string $unit the unit token defined for this unit.
     * @param UnitRangeInterface $unitRange
     *
     * @return static
     */
    public static function from(string $unit, UnitRangeInterface $unitRange): static
    {
        return new static(
            unit: $unit,
            range: $unitRange->getRange(),
            start: $unitRange->getStart(),
            end: $unitRange->getEnd(),
            totalSize: $unitRange->getTotalSize()
        );
    }

    /**
     * @inheritDoc
     */
    public function unit(): string
    {
        return $this->unit;
    }

    /**
     * @inheritDoc
     */
    public function getRange(): string
    {
        return $this->range;
    }

    /**
     * @inheritDoc
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @inheritDoc
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @inheritDoc
     */
    public function getLength()
    {
        return (int) $this->getEnd() - (int) $this->getStart() + 1;
    }

    /**
     * @inheritDoc
     */
    public function getTotalSize()
    {
        return $this->totalSize;
    }
}
