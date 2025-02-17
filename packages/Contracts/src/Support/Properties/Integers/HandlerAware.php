<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Handler Aware
 *
 * Component is aware of int "handler"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface HandlerAware
{
    /**
     * Set handler
     *
     * @param int|null $identifier Identifier of a handler
     *
     * @return self
     */
    public function setHandler(int|null $identifier): static;

    /**
     * Get handler
     *
     * If no handler value set, method
     * sets and returns a default handler.
     *
     * @see getDefaultHandler()
     *
     * @return int|null handler or null if no handler has been set
     */
    public function getHandler(): int|null;

    /**
     * Check if handler has been set
     *
     * @return bool True if handler has been set, false if not
     */
    public function hasHandler(): bool;

    /**
     * Get a default handler value, if any is available
     *
     * @return int|null Default handler value or null if no default value is available
     */
    public function getDefaultHandler(): int|null;
}
