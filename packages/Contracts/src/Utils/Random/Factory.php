<?php

namespace Aedart\Contracts\Utils\Random;

use Random\Engine;

/**
 * Randomizer Factory
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Utils\Random
 */
interface Factory
{
    /**
     * Returns a new randomizer instance of given type
     *
     * @param Type $type
     * @param Engine|null $engine [optional]
     *
     * @return Randomizer
     */
    public static function make(Type $type, Engine|null $engine = null): Randomizer;
}