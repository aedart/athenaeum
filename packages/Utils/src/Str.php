<?php

namespace Aedart\Utils;

use Aedart\Contracts\Utils\Random\StringRandomizer;
use Aedart\Contracts\Utils\Random\Type;
use Aedart\Utils\Random\Factory;
use Illuminate\Support\Str as BaseStr;
use Illuminate\Support\Stringable;
use Random\Engine;

/**
 * String utility
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils
 */
class Str extends BaseStr
{
    /**
     * Returns a new String Randomizer instance
     *
     * @param Engine|null $engine [optional]
     *
     * @return StringRandomizer
     */
    public static function randomizer(Engine|null $engine = null): StringRandomizer
    {
        return Factory::make(Type::String, $engine);
    }

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
