<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Iata Aware
 *
 * Component is aware of string "iata"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface IataAware
{
    /**
     * Set iata
     *
     * @param string|null $code International Air Transport Association code
     *
     * @return self
     */
    public function setIata(string|null $code): static;

    /**
     * Get iata
     *
     * If no iata value set, method
     * sets and returns a default iata.
     *
     * @see getDefaultIata()
     *
     * @return string|null iata or null if no iata has been set
     */
    public function getIata(): string|null;

    /**
     * Check if iata has been set
     *
     * @return bool True if iata has been set, false if not
     */
    public function hasIata(): bool;

    /**
     * Get a default iata value, if any is available
     *
     * @return string|null Default iata value or null if no default value is available
     */
    public function getDefaultIata(): string|null;
}
