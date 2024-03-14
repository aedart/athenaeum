<?php

namespace Aedart\Contracts\Utils\Random;

use Throwable;

/**
 * Array Randomizer
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Utils\Random
 */
interface ArrayRandomizer
{
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
}