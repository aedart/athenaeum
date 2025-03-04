<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Type Aware
 *
 * Component is aware of int "type"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface TypeAware
{
    /**
     * Set type
     *
     * @param int|null $identifier Type identifier
     *
     * @return self
     */
    public function setType(int|null $identifier): static;

    /**
     * Get type
     *
     * If no type value set, method
     * sets and returns a default type.
     *
     * @see getDefaultType()
     *
     * @return int|null type or null if no type has been set
     */
    public function getType(): int|null;

    /**
     * Check if type has been set
     *
     * @return bool True if type has been set, false if not
     */
    public function hasType(): bool;

    /**
     * Get a default type value, if any is available
     *
     * @return int|null Default type value or null if no default value is available
     */
    public function getDefaultType(): int|null;
}
