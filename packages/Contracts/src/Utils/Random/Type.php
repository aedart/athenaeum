<?php

namespace Aedart\Contracts\Utils\Random;

use Aedart\Contracts\Utils\Enums\Concerns;

/**
 * Randomizer Type
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Utils\Random
 */
enum Type
{
    use Concerns\Enums;

    /**
     * Array Randomizer
     */
    case Array;

    /**
     * Numeric Randomizer
     */
    case Numeric;

    /**
     * String (bytes) Randomizer
     */
    case String;
}
