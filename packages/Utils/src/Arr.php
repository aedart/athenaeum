<?php


namespace Aedart\Utils;

use Illuminate\Support\Arr as ArrBase;

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
}
