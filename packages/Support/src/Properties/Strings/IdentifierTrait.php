<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Identifier Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\IdentifierAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait IdentifierTrait
{
    /**
     * Name or code that identifies a unique object, resource, class, component or thing
     *
     * @var string|null
     */
    protected string|null $identifier = null;

    /**
     * Set identifier
     *
     * @param string|null $identifier Name or code that identifies a unique object, resource, class, component or thing
     *
     * @return self
     */
    public function setIdentifier(string|null $identifier): static
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * If no identifier value set, method
     * sets and returns a default identifier.
     *
     * @see getDefaultIdentifier()
     *
     * @return string|null identifier or null if no identifier has been set
     */
    public function getIdentifier(): string|null
    {
        if (!$this->hasIdentifier()) {
            $this->setIdentifier($this->getDefaultIdentifier());
        }
        return $this->identifier;
    }

    /**
     * Check if identifier has been set
     *
     * @return bool True if identifier has been set, false if not
     */
    public function hasIdentifier(): bool
    {
        return isset($this->identifier);
    }

    /**
     * Get a default identifier value, if any is available
     *
     * @return string|null Default identifier value or null if no default value is available
     */
    public function getDefaultIdentifier(): string|null
    {
        return null;
    }
}
