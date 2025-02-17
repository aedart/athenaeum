<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Tld Aware
 *
 * Component is aware of string "tld"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface TldAware
{
    /**
     * Set tld
     *
     * @param string|null $tld Top Level Domain (TLD)
     *
     * @return self
     */
    public function setTld(string|null $tld): static;

    /**
     * Get tld
     *
     * If no tld value set, method
     * sets and returns a default tld.
     *
     * @see getDefaultTld()
     *
     * @return string|null tld or null if no tld has been set
     */
    public function getTld(): string|null;

    /**
     * Check if tld has been set
     *
     * @return bool True if tld has been set, false if not
     */
    public function hasTld(): bool;

    /**
     * Get a default tld value, if any is available
     *
     * @return string|null Default tld value or null if no default value is available
     */
    public function getDefaultTld(): string|null;
}
