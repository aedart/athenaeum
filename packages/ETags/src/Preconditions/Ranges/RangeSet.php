<?php

namespace Aedart\ETags\Preconditions\Ranges;

use Aedart\Contracts\ETags\Preconditions\Ranges\RangeSet as RangeSetInterface;
use Aedart\Utils\Memory;
use InvalidArgumentException;
use Ramsey\Http\Range\Unit\UnitRangeInterface;
use RuntimeException;

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

    /**
     * @inheritDoc
     */
    public function getStartBytes(): int
    {
        return $this->convertToBytes(
            $this->getStart()
        );
    }

    /**
     * @inheritDoc
     */
    public function getEndBytes(): int
    {
        return $this->convertToBytes(
            $this->getEnd()
        );
    }

    /**
     * @inheritDoc
     */
    public function getLengthInBytes(): int
    {
        return $this->convertToBytes(
            $this->getLength()
        );
    }

    /**
     * @inheritDoc
     */
    public function getTotalSizeInBytes(): int
    {
        return $this->convertToBytes(
            $this->getTotalSize()
        );
    }

    /**
     * @inheritDoc
     */
    public function contentRange(): string
    {
        // The "getRange()" output corresponds to whatever was requested.
        // It does not always have a clear start and end. Therefore, we
        // obtain the computed start, end, total... etc.

        $unit = $this->unit();
        $start = $this->getStart();
        $end = $this->getEnd();
        $total = $this->getTotalSize();

        return "{$unit} {$start}-{$end}/{$total}";
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->contentRange();
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Converts given value to bytes
     *
     * @param  mixed  $value
     * @param  string|null  $unit  [optional] Defaults to this range-set's unit, when none given
     *
     * @return int
     *
     * @throws RuntimeException If unable to convert value of given unit to bytes
     */
    protected function convertToBytes(mixed $value, string|null $unit = null): int
    {
        $unit = $unit ?? $this->unit();

        if (!isset($value)) {
            throw new RuntimeException(sprintf('Missing "value" of %s, for range %s', $unit, $this->getRange()));
        }

        try {
            return match ($unit) {
                'bytes' => (int) $value,
                default => Memory::from("{$value} {$unit}")->bytes()
            };
        } catch (InvalidArgumentException $e) {
            throw new RuntimeException(sprintf('Unable to convert %s %s to bytes, for range %s', $value, $unit, $this->getRange()), $e->getCode(), $e);
        }
    }
}
