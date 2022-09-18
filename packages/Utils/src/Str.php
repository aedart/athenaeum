<?php

namespace Aedart\Utils;

use Illuminate\Support\Str as BaseStr;
use Illuminate\Support\Stringable;

/**
 * String utility
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Utils
 */
class Str extends BaseStr
{
    /**
     * Converts slug back to words
     *
     * @param string $slug
     * @param string|string[] $separator [optional]
     *
     * @return Stringable
     */
    public static function slugToWords(string $slug, string|array $separator = ['-', '_', '.']): Stringable
    {
        return static::of($slug)->replace($separator, ' ');
    }

    /**
     * @deprecated Since v6.4. Replaced by {@see \Aedart\Utils\Arr::tree}. Will be removed in next major version.
     *
     * Returns an array that represents a "tree" structure for given string.
     *
     * Example:
     * ```
     * $tree = Str::tree('/home/user/projects')
     *
     * // [ '/home', '/home/user', '/home/user/projects' ]
     * ```
     *
     * @param string $str
     * @param string $delimiter [optional]
     *
     * @return string[]
     */
    public static function tree(string $str, string $delimiter = '/'): array
    {
        return Arr::tree($str, $delimiter);
    }
}
