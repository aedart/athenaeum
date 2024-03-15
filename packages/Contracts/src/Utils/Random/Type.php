<?php

namespace Aedart\Contracts\Utils\Random;

/**
 * Randomizer Type
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Utils\Random
 */
enum Type
{
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
