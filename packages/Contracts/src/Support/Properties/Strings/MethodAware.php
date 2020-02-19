<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * Method Aware
 *
 * Component is aware of string "method"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface MethodAware
{
    /**
     * Set method
     *
     * @param string|null $identifier Name of method or other identifier
     *
     * @return self
     */
    public function setMethod(?string $identifier);

    /**
     * Get method
     *
     * If no "method" value set, method
     * sets and returns a default "method".
     *
     * @see getDefaultMethod()
     *
     * @return string|null method or null if no method has been set
     */
    public function getMethod(): ?string;

    /**
     * Check if "method" has been set
     *
     * @return bool True if "method" has been set, false if not
     */
    public function hasMethod(): bool;

    /**
     * Get a default "method" value, if any is available
     *
     * @return string|null Default "method" value or null if no default value is available
     */
    public function getDefaultMethod(): ?string;
}
