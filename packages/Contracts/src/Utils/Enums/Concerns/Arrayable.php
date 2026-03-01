<?php

namespace Aedart\Contracts\Utils\Enums\Concerns;

/**
 * Concerns Backed Enum Arrayable
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils\Enums\Concerns
 */
trait Arrayable
{
    use Names;
    use Values;

    /**
     * Returns an array representation of this backed enum
     *
     * @return array<string, string|int>
     */
    public static function toArray(): array
    {
        return array_combine(
            static::names(),
            static::values()
        );
    }
}
