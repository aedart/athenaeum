<?php

namespace Aedart\Utils;

use Illuminate\Support\Str as BaseStr;

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
     * @return \Illuminate\Support\Stringable
     */
    public static function slugToWords(string $slug, $separator = ['-', '_', '.'])
    {
        return static::of($slug)->replace($separator, ' ');
    }
}