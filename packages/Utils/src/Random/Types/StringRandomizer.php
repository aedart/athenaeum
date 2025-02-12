<?php

namespace Aedart\Utils\Random\Types;

use Aedart\Contracts\Utils\Random\StringRandomizer as StringRandomizerInterface;

/**
 * String (bytes) Randomizer
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Utils\Random\Types
 */
class StringRandomizer extends BaseRandomizer implements StringRandomizerInterface
{
    /**
     * @inheritDoc
     */
    public function bytes(int $length): string
    {
        return $this->driver()->getBytes($length);
    }

    /**
     * @inheritdoc
     */
    public function bytesFromString(string $string, int $length): string
    {
        return $this->driver()->getBytesFromString($string, $length);
    }

    /**
     * @inheritDoc
     */
    public function shuffle(string $bytes): string
    {
        return $this->driver()->shuffleBytes($bytes);
    }
}
