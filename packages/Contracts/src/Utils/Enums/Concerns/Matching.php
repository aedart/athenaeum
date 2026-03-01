<?php

namespace Aedart\Contracts\Utils\Enums\Concerns;

use BackedEnum;

/**
 * Concerns Enum Matching
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Utils\Enums\Concerns
 */
trait Matching
{
    /**
     * Determine if this enum matches given value
     *
     * @param  mixed  $value
     *
     * @return bool
     */
    public function matches(mixed $value): bool
    {
        if ($this instanceof BackedEnum
            && !($value instanceof static)
            && (is_string($value) || is_int($value))
        ) {
            $value = static::from($value);
        }

        return $this === $value;
    }

    /**
     * Determine if this enum matches any of the given values
     *
     * @param  array  $values
     *
     * @return bool
     */
    public function matchesAny(array $values): bool
    {
        return array_any($values, fn ($value) => $this->matches($value));
    }
}
