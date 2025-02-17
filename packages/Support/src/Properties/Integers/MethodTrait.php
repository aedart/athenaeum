<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Method Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\MethodAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait MethodTrait
{
    /**
     * Name of method or other identifier
     *
     * @var int|null
     */
    protected int|null $method = null;

    /**
     * Set method
     *
     * @param int|null $identifier Name of method or other identifier
     *
     * @return self
     */
    public function setMethod(int|null $identifier): static
    {
        $this->method = $identifier;

        return $this;
    }

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
    public function getMethod(): int|null
    {
        if (!$this->hasMethod()) {
            $this->setMethod($this->getDefaultMethod());
        }
        return $this->method;
    }

    /**
     * Check if method has been set
     *
     * @return bool True if method has been set, false if not
     */
    public function hasMethod(): bool
    {
        return isset($this->method);
    }

    /**
     * Get a default method value, if any is available
     *
     * @return int|null Default method value or null if no default value is available
     */
    public function getDefaultMethod(): int|null
    {
        return null;
    }
}
