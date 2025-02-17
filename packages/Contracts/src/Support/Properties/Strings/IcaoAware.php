<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Icao Aware
 *
 * Component is aware of string "icao"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface IcaoAware
{
    /**
     * Set icao
     *
     * @param string|null $code International Civil Aviation Organization code
     *
     * @return self
     */
    public function setIcao(string|null $code): static;

    /**
     * Get icao
     *
     * If no icao value set, method
     * sets and returns a default icao.
     *
     * @see getDefaultIcao()
     *
     * @return string|null icao or null if no icao has been set
     */
    public function getIcao(): string|null;

    /**
     * Check if icao has been set
     *
     * @return bool True if icao has been set, false if not
     */
    public function hasIcao(): bool;

    /**
     * Get a default icao value, if any is available
     *
     * @return string|null Default icao value or null if no default value is available
     */
    public function getDefaultIcao(): string|null;
}
