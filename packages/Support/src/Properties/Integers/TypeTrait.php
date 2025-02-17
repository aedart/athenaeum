<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Type Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\TypeAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait TypeTrait
{
    /**
     * Type identifier
     *
     * @var int|null
     */
    protected int|null $type = null;

    /**
     * Set type
     *
     * @param int|null $identifier Type identifier
     *
     * @return self
     */
    public function setType(int|null $identifier): static
    {
        $this->type = $identifier;

        return $this;
    }

    /**
     * Get type
     *
     * If no type value set, method
     * sets and returns a default type.
     *
     * @see getDefaultType()
     *
     * @return int|null type or null if no type has been set
     */
    public function getType(): int|null
    {
        if (!$this->hasType()) {
            $this->setType($this->getDefaultType());
        }
        return $this->type;
    }

    /**
     * Check if type has been set
     *
     * @return bool True if type has been set, false if not
     */
    public function hasType(): bool
    {
        return isset($this->type);
    }

    /**
     * Get a default type value, if any is available
     *
     * @return int|null Default type value or null if no default value is available
     */
    public function getDefaultType(): int|null
    {
        return null;
    }
}
