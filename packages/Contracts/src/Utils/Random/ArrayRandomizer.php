<?php

namespace Aedart\Contracts\Utils\Random;

use Throwable;

/**
 * Array Randomizer
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Utils\Random
 */
interface ArrayRandomizer extends Randomizer
{
    /**
     * Returns a single random key
     *
     * @param array $arr
     *
     * @return string|int
     *
     * @throws Throwable
     */
    public function pickKey(array $arr): string|int;

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
     * Returns a random entry (value) from array
     *
     * @param array $arr
     *
     * @return mixed
     *
     * @throws Throwable
     */
    public function value(array $arr): mixed;

    /**
     * Returns random entries (values) from array
     *
     * @param array $arr
     * @param int $amount Amount of entries to return
     * @param bool $preserveKeys [optional]
     *
     * @return array
     *
     * @throws Throwable
     */
    public function values(array $arr, int $amount, bool $preserveKeys = false): array;

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
}
