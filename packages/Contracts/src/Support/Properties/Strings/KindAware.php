<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Kind Aware
 *
 * Component is aware of string "kind"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface KindAware
{
    /**
     * Set kind
     *
     * @param string|null $kind The kind of object this represents, e.g. human, organisation, group, individual...etc
     *
     * @return self
     */
    public function setKind(string|null $kind): static;

    /**
     * Get kind
     *
     * If no kind value set, method
     * sets and returns a default kind.
     *
     * @see getDefaultKind()
     *
     * @return string|null kind or null if no kind has been set
     */
    public function getKind(): string|null;

    /**
     * Check if kind has been set
     *
     * @return bool True if kind has been set, false if not
     */
    public function hasKind(): bool;

    /**
     * Get a default kind value, if any is available
     *
     * @return string|null Default kind value or null if no default value is available
     */
    public function getDefaultKind(): string|null;
}
