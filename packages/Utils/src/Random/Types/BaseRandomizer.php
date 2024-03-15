<?php

namespace Aedart\Utils\Random\Types;

use Aedart\Contracts\Utils\Random\Randomizer;
use Random\Randomizer as NativeRandomizer;

/**
 * Base Randomizer
 *
 * @see \Aedart\Contracts\Utils\Random\Randomizer
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Utils\Random
 */
abstract class BaseRandomizer implements Randomizer
{
    /**
     * The underlying driver of this randomizer
     *
     * @var NativeRandomizer
     */
    protected NativeRandomizer $driver;

    /**
     * Creates a new Randomizer instance
     *
     * @param NativeRandomizer|null $driver [optional]
     */
    public function __construct(NativeRandomizer|null $driver = null)
    {
        $this->driver = $driver ?? $this->makeDefaultDriver();
    }

    /**
     * @inheritDoc
     */
    public function driver(): NativeRandomizer
    {
        return $this->driver;
    }

    /**
     * Returns a default driver
     *
     * @return NativeRandomizer
     */
    protected function makeDefaultDriver(): NativeRandomizer
    {
        return new NativeRandomizer();
    }
}
