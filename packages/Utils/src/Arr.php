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
     * @see \Aedart\Utils\Math::applySeed
     *
     * @param array $list
     * @param int|null $seed [optional] Number to seed the random generator.
     * @param int $mode [optional] The seeding algorithm to use
     *
     * @return mixed
     */
    public static function randomElement(array $list, int|null $seed = null, int $mode = MT_RAND_MT19937): mixed
    {
        // Seed generator if required
        if (isset($seed)) {
            Math::applySeed($seed, $mode);
        }

        $index = array_rand($list, 1);

        return $list[$index];
    }

    /**
     * Computes the difference of multidimensional arrays
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

        $array = static::clearNestedEmptyArrays(
            static::dot($array)
        );

        $arrays = array_map(function ($array) {
            return static::clearNestedEmptyArrays(
                static::dot($array)
            );
        }, $arrays);

        return static::undot(array_diff_assoc($array, ...$arrays));
    }

    /**
     * Returns an array that represents a "tree" structure for given path.
     *
     * Example:
     * ```
     * $tree = Arr::tree('/home/user/projects')
     *
     * // [ '/home', '/home/user', '/home/user/projects' ]
     * ```
     *
     * @param string $path
     * @param string $delimiter [optional]
     *
     * @return string[]
     */
    public static function tree(string $path, string $delimiter = '/'): array
    {
        $output = [];
        $parts = explode($delimiter, $path);

        $previousElement = '';
        foreach ($parts as $element) {
            if (!empty($element)) {
                $output[] = $previousElement . $element;
            }

            $previousElement .= $element . $delimiter;
        }

        return $output;
    }

    /**
     * Replaces nested empty array values
     *
     * @param array $array
     * @param mixed $replaceValue [optional] Value to replace empty arrays with
     *
     * @return array
     */
    protected static function clearNestedEmptyArrays(array $array, mixed $replaceValue = null): array
    {
        $output = [];

        foreach ($array as $key => $value) {
            if (is_array($value) && empty($value)) {
                $value = $replaceValue;
            }

            $output[$key] = $value;
        }

        return $output;
    }
}
