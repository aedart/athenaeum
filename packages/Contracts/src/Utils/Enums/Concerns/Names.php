<?php

namespace Aedart\Contracts\Utils\Enums\Concerns;

use UnitEnum;

/**
 * Concerns Enum Names
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils\Enums\Concerns
 */
trait Names
{
    /**
     * Returns the names of this enum's cases
     *
     * @return string[]
     */
    public static function names(): array
    {
        return array_map(static fn (UnitEnum $enum) => $enum->name, static::cases());
    }
}
