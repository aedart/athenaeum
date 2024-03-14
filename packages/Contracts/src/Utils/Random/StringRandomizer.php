<?php

namespace Aedart\Contracts\Utils\Random;

use Throwable;

/**
 * String Randomizer
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Utils\Random
 */
interface StringRandomizer
{
    /**
     * Returns random bytes
     *
     * @param int $length
     *
     * @return string
     *
     * @throws Throwable
     */
    public function bytes(int $length): string;

    /**
     * Shuffles given bytes
     *
     * @param string $bytes
     *
     * @return string New shuffled bytes
     *
     * @throws Throwable
     */
    public function shuffleBytes(string $bytes): string;
}