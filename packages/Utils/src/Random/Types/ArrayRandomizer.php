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
    public function pickKey(array $arr): string|int
    {
        return $this->pickKeys($arr, 1)[0];
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
    public function value(array $arr): mixed
    {
        return $this->values($arr, 1)[0];
    }

    /**
     * @inheritDoc
     */
    public function values(array $arr, int $amount, bool $preserveKeys = false): array
    {
        $keys = $this->pickKeys($arr, $amount);

        $output = [];
        foreach ($keys as $key) {
            if ($preserveKeys) {
                $output[$key] = $arr[$key];
                continue;
            }

            $output[] = $arr[$key];
        }

        return $output;
    }

    /**
     * @inheritDoc
     */
    public function shuffle(array $arr): array
    {
        return $this->driver()->shuffleArray($arr);
    }
}
