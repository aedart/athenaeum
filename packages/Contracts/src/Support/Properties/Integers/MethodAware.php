<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Method Aware
 *
 * Component is aware of int "method"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface MethodAware
{
    /**
     * Set method
     *
     * @param int|null $identifier Name of method or other identifier
     *
     * @return self
     */
    public function setMethod(int|null $identifier): static;

    /**
     * Get method
     *
     * If no method value set, method
     * sets and returns a default method.
     *
     * @see getDefaultMethod()
     *
     * @return int|null method or null if no method has been set
     */
    public function getMethod(): int|null;

    /**
     * Check if method has been set
     *
     * @return bool True if method has been set, false if not
     */
    public function hasMethod(): bool;

    /**
     * Get a default method value, if any is available
     *
     * @return int|null Default method value or null if no default value is available
     */
    public function getDefaultMethod(): int|null;
}
