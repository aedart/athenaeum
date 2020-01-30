<?php

namespace Aedart\Utils;

/**
 * Math Utility
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils
 */
class Math
{
    /**
     * Generates a seed based on microtime
     *
     * Resulting seed can be used to seed the Mersenne Twister Random Number Generator
     *
     * @see mt_srand
     * @see https://www.php.net/manual/en/function.mt-srand.php#refsect1-function.mt-srand-examples
     *
     * @return int
     */
    public static function makeSeed() : int
    {
        list($usec, $sec) = explode(' ', microtime());
        return $sec + $usec * 1000000;
    }
}
