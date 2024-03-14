<?php

namespace Aedart\Contracts\Utils\Random;

use Throwable;

/**
 * Randomizer
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Utils\Random
 */
interface Randomizer
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
     */
    public function nextInt(): int;

    /**
     * Returns random array keys
     *
     * @param array $arr
     * @param int $amount Amount of keys to return
     *
     * @return array<string>|array<int>
     *
     * @throws Throwable
     */
    public function pickKeys(array $arr, int $amount): array;

    /**
     * Shuffles given array
     *
     * @param array $arr
     *
     * @return array New shuffled array
     *
     * @throws Throwable
     */
    public function shuffle(array $arr): array;

    /**
     * Shuffles given bytes
     *
     * @param string $bytes
     *
     * @return string New shuffled bytes
     */
    public function shuffleBytes(string $bytes): string;

    /**
     * Returns the underlying driver of this randomizer
     *
     * @return mixed
     */
    public function driver(): mixed;
}
