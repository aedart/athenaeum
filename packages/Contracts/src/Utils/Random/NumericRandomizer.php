<?php

namespace Aedart\Contracts\Utils\Random;

use Random\IntervalBoundary;
use Throwable;

/**
 * Numeric Randomizer
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Utils\Random
 */
interface NumericRandomizer extends Randomizer
{
    /**
     * Returns a uniformly selected integer
     *
     * @see https://www.php.net/manual/en/random-randomizer.getint.php
     *
     * @param int $min
     * @param int $max
     *
     * @return int
     *
     * @throws Throwable
     */
    public function int(int $min, int $max): int;

    /**
     * Returns next positive integer
     *
     * @see https://www.php.net/manual/en/random-randomizer.nextint.php
     *
     * @return int
     *
     * @throws Throwable
     */
    public function nextInt(): int;

    /**
     * Returns a uniformly selected float
     *
     * @see https://www.php.net/manual/en/random-randomizer.getfloat.php
     *
     * @param float $min
     * @param float $max
     * @param IntervalBoundary $boundary [optional]
     *
     * @return float
     */
    public function float(float $min, float $max, IntervalBoundary $boundary = IntervalBoundary::ClosedOpen): float;

    /**
     * Get the next float
     *
     * @see https://www.php.net/manual/en/random-randomizer.nextfloat.php
     *
     * @return float
     */
    public function nextFloat(): float;
}
