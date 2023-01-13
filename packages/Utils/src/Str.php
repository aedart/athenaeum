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
}
