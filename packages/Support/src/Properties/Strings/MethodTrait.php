<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Method Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\MethodAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait MethodTrait
{
    /**
     * Name of method or other identifier
     *
     * @var string|null
     */
    protected ?string $method = null;

    /**
     * Set method
     *
     * @param string|null $identifier Name of method or other identifier
     *
     * @return self
     */
    public function setMethod(?string $identifier)
    {
        $this->method = $identifier;

        return $this;
    }

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
    public function getMethod() : ?string
    {
        if ( ! $this->hasMethod()) {
            $this->setMethod($this->getDefaultMethod());
        }
        return $this->method;
    }

    /**
     * Check if "method" has been set
     *
     * @return bool True if "method" has been set, false if not
     */
    public function hasMethod() : bool
    {
        return isset($this->method);
    }

    /**
     * Get a default "method" value, if any is available
     *
     * @return string|null Default "method" value or null if no default value is available
     */
    public function getDefaultMethod() : ?string
    {
        return null;
    }
}
