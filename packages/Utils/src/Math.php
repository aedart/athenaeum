<?php

namespace Aedart\Utils;

use RuntimeException;
use Throwable;

/**
 * Math Utility
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils
 */
class Math
{
    /**
     * Generates a random number between given min and max values
     *
     * @param int $min [optional] Must be greater than or equals PHP_INT_MIN
     * @param int $max [optional] Must be less than or equals PHP_INT_MAX
     *
     * @return int
     *
     * @throws RuntimeException If arguments are invalid or unable to generate enough randomness
     */
    public static function randomInt(int $min = PHP_INT_MIN, int $max = PHP_INT_MAX) : int
    {
        try {
            return random_int($min, $max);
        } catch (Throwable $e) {
            throw new RuntimeException(
                'Unable to generate random number: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Generates a seed that can be used for the random number generator
     *
     * @see mt_srand
     * @see https://www.php.net/manual/en/function.mt-srand.php#refsect1-function.mt-srand-examples
     *
     * @return int
     */
    public static function seed() : int
    {
        list($usec, $sec) = explode(' ', microtime());
        return $sec + $usec * 1000000;
    }
}
