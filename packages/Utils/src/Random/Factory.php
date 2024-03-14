<?php

namespace Aedart\Utils\Random;

use Aedart\Contracts\Utils\Random\Randomizer as RandomizerInterface;
use Random\Engine;
use Random\Randomizer as NativeRandomizer;

/**
 * Randomizer Factory
 *
 * @see \Aedart\Contracts\Utils\Random\Randomizer
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Utils\Random
 */
class Factory
{
    /**
     * Returns a new Randomizer instance, using given engine
     *
     * @see https://www.php.net/manual/en/random-randomizer.construct.php
     *
     * @param Engine|null $engine [optional]
     *
     * @return RandomizerInterface
     */
    public static function make(Engine|null $engine = null): RandomizerInterface
    {
        $driver = new NativeRandomizer($engine);

        return new Randomizer($driver);
    }
}
