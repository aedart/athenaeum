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
        if(isset($seed)){
            mt_srand($seed);
        }

        $index = array_rand($list, 1);

        return $list[$index];
    }
}
