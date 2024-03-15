<?php

namespace Aedart\Utils\Random;

use Aedart\Contracts\Utils\Random\Factory as RandomizerFactory;
use Aedart\Contracts\Utils\Random\Randomizer as RandomizerInterface;
use Aedart\Contracts\Utils\Random\Type;
use Aedart\Utils\Random\Types\ArrayRandomizer;
use Aedart\Utils\Random\Types\NumericRandomizer;
use Aedart\Utils\Random\Types\StringRandomizer;
use Random\Engine;
use Random\Randomizer;

/**
 * Randomizer Factory
 *
 * @see \Aedart\Contracts\Utils\Random\Randomizer
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Utils\Random
 */
class Factory implements RandomizerFactory
{
    /**
     * @inheritDoc
     */
    public static function make(Type $type, Engine|null $engine = null): RandomizerInterface
    {
        $driver = static::makeDriver($engine);

        return match ($type) {
            Type::Array => new ArrayRandomizer($driver),
            Type::String => new StringRandomizer($driver),
            Type::Numeric => new NumericRandomizer($driver)
        };
    }

    /**
     * Returns a new driver instance
     *
     * @see https://www.php.net/manual/en/class.random-randomizer.php
     *
     * @param Engine|null $engine [optional]
     *
     * @return Randomizer
     */
    protected static function makeDriver(Engine|null $engine = null): Randomizer
    {
        return new Randomizer($engine);
    }
}
