<?php

namespace Aedart\Utils\Random\Types;

use Aedart\Contracts\Utils\Random\ArrayRandomizer as ArrayRandomizerInterface;

/**
 * Array Randomizer
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Utils\Random\Types
 */
class ArrayRandomizer extends BaseRandomizer implements ArrayRandomizerInterface
{
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
}
