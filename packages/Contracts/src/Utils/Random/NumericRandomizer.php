<?php

namespace Aedart\Contracts\Utils\Random;

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
     * @return int
     *
     * @throws Throwable
     */
    public function nextInt(): int;
}
