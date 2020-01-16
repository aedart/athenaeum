<?php

namespace Aedart\Support\Properties\Strings;

/**
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
    protected ?string $handler = null;

    /**
     * Set handler
     *
     * @param string|null $identifier Identifier of a handler
     *
     * @return self
     */
    public function setHandler(?string $identifier)
    {
        $this->handler = $identifier;

        return $this;
    }

    /**
     * Get handler
     *
     * If no "handler" value set, method
     * sets and returns a default "handler".
     *
     * @see getDefaultHandler()
     *
     * @return string|null handler or null if no handler has been set
     */
    public function getHandler() : ?string
    {
        if ( ! $this->hasHandler()) {
            $this->setHandler($this->getDefaultHandler());
        }
        return $this->handler;
    }

    /**
     * Check if "handler" has been set
     *
     * @return bool True if "handler" has been set, false if not
     */
    public function hasHandler() : bool
    {
        return isset($this->handler);
    }

    /**
     * Get a default "handler" value, if any is available
     *
     * @return string|null Default "handler" value or null if no default value is available
     */
    public function getDefaultHandler() : ?string
    {
        return null;
    }
}
