<?php


namespace Aedart\Utils;

use Illuminate\Support\Arr as ArrBase;
use InvalidArgumentException;

/**
 * Array Utility
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils
 */
class Arr extends ArrBase
{
    /**
     * Returns a single random element from given list
     *
     * @param array $list
     * @param int|null $seed [optional] Number to seed the random generator.
     *
     * @return mixed
     */
    public static function randomElement(array $list, int $seed = null)
    {
        // Seed generator if required
        if (isset($seed)) {
            mt_srand($seed);
        }

        $index = array_rand($list, 1);

        return $list[$index];
    }

    /**
     * Un-flatten an array that has been flatten via "dot"
     *
     * @see dot
     *
     * @param  array|iterable  $array
     *
     * @return array
     */
    public static function undot($array): array
    {
        $output = [];

        foreach ($array as $key => $value) {
            static::set($output, $key, $value);
        }

        return $output;
    }

    /**
     * Computes the difference of multi-dimensional arrays
     *
     * @param array $array The array to compare from
     * @param array ...$arrays Arrays to compare against
     *
     * @return array Array containing values that are not present in any of the other arrays.
     *
     * @throws InvalidArgumentException If less than 2 arguments are provided
     */
    public static function differenceAssoc(array $array, array ...$arrays): array
    {
        if (empty($arrays)) {
            throw new InvalidArgumentException('You need at least 2 arrays for computing difference');
        }

        $array = static::dot($array);

        $arrays = array_map(function($item) {
            return static::dot($item);
        }, $arrays);

        return static::undot(array_diff_assoc($array, ...$arrays));
    }
}
