<?php

namespace Aedart\Utils;

use Aedart\Contracts\Utils\Random\NumericRandomizer;
use Aedart\Contracts\Utils\Random\Type;
use Aedart\Utils\Random\Factory;
use Random\Engine;

/**
 * Math Utility
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils
 */
class Math
{
    /**
     * Returns a new Numeric Randomizer instance
     *
     * @param Engine|null $engine [optional]
     *
     * @return NumericRandomizer
     */
    public static function randomizer(Engine|null $engine = null): NumericRandomizer
    {
        return Factory::make(Type::Numeric, $engine);
    }

    /**
     * Generates a seed that can be used for the random number generator
     *
     * @see applySeed
     * @see mt_srand
     *
     * @return int
     */
    public static function seed(): int
    {
        // Source is from php.net's documentation:
        // @see https://www.php.net/manual/en/function.mt-srand.php#refsect1-function.mt-srand-examples
        [$usec, $sec] = explode(' ', microtime());
        return (int) $sec + $usec * 1000000;
    }

    /**
     * Seeds the Mersenne Twister Random Number Generator
     *
     * **WARNING**: If you choose to seed the random number generator,
     * all methods that depend on it will be affected.
     *
     * @see seed
     * @see https://www.php.net/manual/en/function.mt-srand.php
     *
     * @param int $seed [optional] Seed value
     * @param int $mode [optional] The algorithm to use
     */
    public static function applySeed(int $seed = 0, int $mode = MT_RAND_MT19937): void
    {
        mt_srand($seed, $mode);
    }
}
