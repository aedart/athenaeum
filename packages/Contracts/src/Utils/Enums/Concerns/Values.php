<?php

namespace Aedart\Contracts\Utils\Enums\Concerns;

use BackedEnum;

/**
 * Concerns Backed Enum Values
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils\Enums\Concerns
 */
trait Values
{
    /**
     * Returns the values of this backed enum's cases
     *
     * @return array<string|int>
     */
    public static function values(): array
    {
        return array_map(static fn (BackedEnum $enum) => $enum->value, static::cases());
    }
}
