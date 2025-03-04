<?php

namespace Aedart\Contracts\Utils\Random;

use Throwable;

/**
 * String (Bytes) Randomizer
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Utils\Random
 */
interface StringRandomizer extends Randomizer
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
     * Returns random bytes from given string
     *
     * @param string $string
     * @param int $length
     *
     * @return string
     *
     * @throws Throwable
     */
    public function bytesFromString(string $string, int $length): string;

    /**
     * Shuffles given bytes
     *
     * @param string $bytes
     *
     * @return string New shuffled bytes
     *
     * @throws Throwable
     */
    public function shuffle(string $bytes): string;
}
