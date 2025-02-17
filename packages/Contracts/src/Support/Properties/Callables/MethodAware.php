<?php

namespace Aedart\Contracts\Support\Properties\Callables;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Method Aware
 *
 * Component is aware of callable "method"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Callables
 */
interface MethodAware
{
    /**
     * Set method
     *
     * @param callable|null $callback Callback method
     *
     * @return self
     */
    public function setMethod(callable|null $callback): static;

    /**
     * Get method
     *
     * If no method value set, method
     * sets and returns a default method.
     *
     * @see getDefaultMethod()
     *
     * @return callable|null method or null if no method has been set
     */
    public function getMethod(): callable|null;

    /**
     * Check if method has been set
     *
     * @return bool True if method has been set, false if not
     */
    public function hasMethod(): bool;

    /**
     * Get a default method value, if any is available
     *
     * @return callable|null Default method value or null if no default value is available
     */
    public function getDefaultMethod(): callable|null;
}
