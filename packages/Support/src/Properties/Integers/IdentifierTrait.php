<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Identifier Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\IdentifierAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait IdentifierTrait
{
    /**
     * Name or code that identifies a unique object, resource, class, component or thing
     *
     * @var int|null
     */
    protected int|null $identifier = null;

    /**
     * Set identifier
     *
     * @param int|null $identifier Name or code that identifies a unique object, resource, class, component or thing
     *
     * @return self
     */
    public function setIdentifier(int|null $identifier): static
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
     * @return int|null identifier or null if no identifier has been set
     */
    public function getIdentifier(): int|null
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
     * @return int|null Default identifier value or null if no default value is available
     */
    public function getDefaultIdentifier(): int|null
    {
        return null;
    }
}
