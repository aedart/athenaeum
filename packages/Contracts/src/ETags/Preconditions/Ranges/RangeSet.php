<?php

namespace Aedart\Contracts\ETags\Preconditions\Ranges;

use Ramsey\Http\Range\Unit\UnitRangeInterface;
use RuntimeException;
use Stringable;

/**
 * Range-Set
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\ETags\Preconditions\Ranges
 */
interface RangeSet extends UnitRangeInterface, Stringable
{
    /**
     * Returns the unit token defined for this unit.
     *
     * @return string E.g. bytes
     */
    public function unit(): string;

    /**
     * Returns the start of the range (bytes)
     *
     * @return int
     *
     * @throws RuntimeException
     */
    public function getStartBytes(): int;

    /**
     * Returns the end of the range (bytes)
     *
     * @return int
     *
     * @throws RuntimeException
     */
    public function getEndBytes(): int;

    /**
     * Returns the length of this range in bytes
     *
     * @return int
     *
     * @throws RuntimeException
     */
    public function getLengthInBytes(): int;

    /**
     * Returns the total size of the entity in bytes
     *
     * @return int
     *
     * @throws RuntimeException
     */
    public function getTotalSizeInBytes(): int;

    /**
     * Returns the value of a Content-Range header
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Range
     *
     * @return string E.g. bytes 200-1000/67589
     */
    public function contentRange(): string;
}
