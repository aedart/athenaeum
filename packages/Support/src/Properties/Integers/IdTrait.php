<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Id Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\IdAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait IdTrait
{
    /**
     * Unique identifier
     *
     * @var int|null
     */
    protected int|null $id = null;

    /**
     * Set id
     *
     * @param int|null $identifier Unique identifier
     *
     * @return self
     */
    public function setId(int|null $identifier): static
    {
        $this->id = $identifier;

        return $this;
    }

    /**
     * Get id
     *
     * If no id value set, method
     * sets and returns a default id.
     *
     * @see getDefaultId()
     *
     * @return int|null id or null if no id has been set
     */
    public function getId(): int|null
    {
        if (!$this->hasId()) {
            $this->setId($this->getDefaultId());
        }
        return $this->id;
    }

    /**
     * Check if id has been set
     *
     * @return bool True if id has been set, false if not
     */
    public function hasId(): bool
    {
        return isset($this->id);
    }

    /**
     * Get a default id value, if any is available
     *
     * @return int|null Default id value or null if no default value is available
     */
    public function getDefaultId(): int|null
    {
        return null;
    }
}
