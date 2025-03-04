<?php

namespace Aedart\Support\Properties\Callables;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Method Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Callables\MethodAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Callables
 */
trait MethodTrait
{
    /**
     * Callback method
     *
     * @var callable|null
     */
    protected $method = null;

    /**
     * Set method
     *
     * @param callable|null $callback Callback method
     *
     * @return self
     */
    public function setMethod(callable|null $callback): static
    {
        $this->method = $callback;

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
     * @return callable|null method or null if no method has been set
     */
    public function getMethod(): callable|null
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
     * @return callable|null Default method value or null if no default value is available
     */
    public function getDefaultMethod(): callable|null
    {
        return null;
    }
}
