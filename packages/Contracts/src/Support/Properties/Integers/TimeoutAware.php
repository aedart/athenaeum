<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Timeout Aware
 *
 * Component is aware of int "timeout"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface TimeoutAware
{
    /**
     * Set timeout
     *
     * @param int|null $amount Timeout amount
     *
     * @return self
     */
    public function setTimeout(int|null $amount): static;

    /**
     * Get timeout
     *
     * If no timeout value set, method
     * sets and returns a default timeout.
     *
     * @see getDefaultTimeout()
     *
     * @return int|null timeout or null if no timeout has been set
     */
    public function getTimeout(): int|null;

    /**
     * Check if timeout has been set
     *
     * @return bool True if timeout has been set, false if not
     */
    public function hasTimeout(): bool;

    /**
     * Get a default timeout value, if any is available
     *
     * @return int|null Default timeout value or null if no default value is available
     */
    public function getDefaultTimeout(): int|null;
}
