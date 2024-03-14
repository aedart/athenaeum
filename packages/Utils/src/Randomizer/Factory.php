<?php

namespace Aedart\Utils\Randomizer;

use Random\Engine;
use Random\Randomizer;

/**
 * Randomizer Factory
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Utils\Random
 */
class Factory
{
    /**
     * Returns a new Randomizer instance with given engine
     *
     * Method is an alias for {@see Randomizer::__construct()}.
     *
     * @see https://www.php.net/manual/en/random-randomizer.construct.php
     *
     * @param Engine|null $engine [optional]
     *
     * @return Randomizer
     */
    public static function make(Engine|null $engine = null): Randomizer
    {
        return new Randomizer($engine);
    }
}