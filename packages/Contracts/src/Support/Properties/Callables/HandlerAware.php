<?php

namespace Aedart\Contracts\Support\Properties\Callables;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Handler Aware
 *
 * Component is aware of callable "handler"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Callables
 */
interface HandlerAware
{
    /**
     * Set handler
     *
     * @param callable|null $callback Handler callback method
     *
     * @return self
     */
    public function setHandler(callable|null $callback): static;

    /**
     * Get handler
     *
     * If no handler value set, method
     * sets and returns a default handler.
     *
     * @see getDefaultHandler()
     *
     * @return callable|null handler or null if no handler has been set
     */
    public function getHandler(): callable|null;

    /**
     * Check if handler has been set
     *
     * @return bool True if handler has been set, false if not
     */
    public function hasHandler(): bool;

    /**
     * Get a default handler value, if any is available
     *
     * @return callable|null Default handler value or null if no default value is available
     */
    public function getDefaultHandler(): callable|null;
}
