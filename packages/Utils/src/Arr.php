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
     * @param bool $shuffle [optional] If true, list is shuffled first
     * @param int|null $seed [optional] Number to seed the random generator. Only used if shuffle set to true
     *
     * @return mixed
     */
    public static function randomElement(array $list, bool $shuffle = false, int $seed = null)
    {
        if($shuffle){
            $list = static::shuffle($list, $seed);
        }

        $index = array_rand($list, 1);

        return $list[$index];
    }
}
