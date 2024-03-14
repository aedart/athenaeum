<?php

namespace Aedart\Utils\Random;

use Aedart\Contracts\Utils\Random\Randomizer as RandomizerInterface;
use Random\Randomizer as NativeRandomizer;

/**
 * Randomizer
 *
 * This Randomizer acts as an adapter for PHP's native {@see \Random\Randomizer}.
 *
 * @see \Aedart\Contracts\Utils\Random\Randomizer
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Utils\Random
 */
class Randomizer implements RandomizerInterface
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
    public function bytes(int $length): string
    {
        return $this->driver()->getBytes($length);
    }

    /**
     * @inheritDoc
     */
    public function int(int $min, int $max): int
    {
        return $this->driver()->getInt($min, $max);
    }

    /**
     * @inheritDoc
     */
    public function nextInt(): int
    {
        return $this->driver()->nextInt();
    }

    /**
     * @inheritDoc
     */
    public function pickKeys(array $arr, int $amount): array
    {
        return $this->driver()->pickArrayKeys($arr, $amount);
    }

    /**
     * @inheritDoc
     */
    public function shuffle(array $arr): array
    {
        return $this->driver()->shuffleArray($arr);
    }

    /**
     * @inheritDoc
     */
    public function shuffleBytes(string $bytes): string
    {
        return $this->driver()->shuffleBytes($bytes);
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
