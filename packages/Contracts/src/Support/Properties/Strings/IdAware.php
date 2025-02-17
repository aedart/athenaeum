<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Id Aware
 *
 * Component is aware of string "id"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface IdAware
{
    /**
     * Set id
     *
     * @param string|null $identifier Unique identifier
     *
     * @return self
     */
    public function setId(string|null $identifier): static;

    /**
     * Get id
     *
     * If no id value set, method
     * sets and returns a default id.
     *
     * @see getDefaultId()
     *
     * @return string|null id or null if no id has been set
     */
    public function getId(): string|null;

    /**
     * Check if id has been set
     *
     * @return bool True if id has been set, false if not
     */
    public function hasId(): bool;

    /**
     * Get a default id value, if any is available
     *
     * @return string|null Default id value or null if no default value is available
     */
    public function getDefaultId(): string|null;
}
