<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Error Aware
 *
 * Component is aware of int "error"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface ErrorAware
{
    /**
     * Set error
     *
     * @param int|null $identifier Error name or identifier
     *
     * @return self
     */
    public function setError(int|null $identifier): static;

    /**
     * Get error
     *
     * If no error value set, method
     * sets and returns a default error.
     *
     * @see getDefaultError()
     *
     * @return int|null error or null if no error has been set
     */
    public function getError(): int|null;

    /**
     * Check if error has been set
     *
     * @return bool True if error has been set, false if not
     */
    public function hasError(): bool;

    /**
     * Get a default error value, if any is available
     *
     * @return int|null Default error value or null if no default value is available
     */
    public function getDefaultError(): int|null;
}
