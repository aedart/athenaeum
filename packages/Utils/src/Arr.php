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
     *
     * @return mixed
     */
    public static function randomElement(array $list, bool $shuffle = true)
    {
        if($shuffle){
            $list = static::shuffle($list, Math::seed());
        }

        $index = array_rand($list, 1);

        return $list[$index];
    }
}
