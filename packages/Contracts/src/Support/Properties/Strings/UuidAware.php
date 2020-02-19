<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * Uuid Aware
 *
 * Component is aware of string "uuid"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface UuidAware
{
    /**
     * Set uuid
     *
     * @param string|null $identifier Universally Unique Identifier (UUID)
     *
     * @return self
     */
    public function setUuid(?string $identifier);

    /**
     * Get uuid
     *
     * If no "uuid" value set, method
     * sets and returns a default "uuid".
     *
     * @see getDefaultUuid()
     *
     * @return string|null uuid or null if no uuid has been set
     */
    public function getUuid(): ?string;

    /**
     * Check if "uuid" has been set
     *
     * @return bool True if "uuid" has been set, false if not
     */
    public function hasUuid(): bool;

    /**
     * Get a default "uuid" value, if any is available
     *
     * @return string|null Default "uuid" value or null if no default value is available
     */
    public function getDefaultUuid(): ?string;
}
