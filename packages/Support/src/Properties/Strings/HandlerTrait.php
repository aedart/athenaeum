<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Handler Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\HandlerAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait HandlerTrait
{
    /**
     * Identifier of a handler
     *
     * @var string|null
     */
    protected string|null $handler = null;

    /**
     * Set handler
     *
     * @param string|null $identifier Identifier of a handler
     *
     * @return self
     */
    public function setHandler(string|null $identifier): static
    {
        $this->handler = $identifier;

        return $this;
    }

    /**
     * Get handler
     *
     * If no handler value set, method
     * sets and returns a default handler.
     *
     * @see getDefaultHandler()
     *
     * @return string|null handler or null if no handler has been set
     */
    public function getHandler(): string|null
    {
        if (!$this->hasHandler()) {
            $this->setHandler($this->getDefaultHandler());
        }
        return $this->handler;
    }

    /**
     * Check if handler has been set
     *
     * @return bool True if handler has been set, false if not
     */
    public function hasHandler(): bool
    {
        return isset($this->handler);
    }

    /**
     * Get a default handler value, if any is available
     *
     * @return string|null Default handler value or null if no default value is available
     */
    public function getDefaultHandler(): string|null
    {
        return null;
    }
}
