<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Created at Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\CreatedAtAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait CreatedAtTrait
{
    /**
     * Date of when this component, entity or resource was created
     *
     * @var string|null
     */
    protected string|null $createdAt = null;

    /**
     * Set created at
     *
     * @param string|null $date Date of when this component, entity or resource was created
     *
     * @return self
     */
    public function setCreatedAt(string|null $date): static
    {
        $this->createdAt = $date;

        return $this;
    }

    /**
     * Get created at
     *
     * If no created at value set, method
     * sets and returns a default created at.
     *
     * @see getDefaultCreatedAt()
     *
     * @return string|null created at or null if no created at has been set
     */
    public function getCreatedAt(): string|null
    {
        if (!$this->hasCreatedAt()) {
            $this->setCreatedAt($this->getDefaultCreatedAt());
        }
        return $this->createdAt;
    }

    /**
     * Check if created at has been set
     *
     * @return bool True if created at has been set, false if not
     */
    public function hasCreatedAt(): bool
    {
        return isset($this->createdAt);
    }

    /**
     * Get a default created at value, if any is available
     *
     * @return string|null Default created at value or null if no default value is available
     */
    public function getDefaultCreatedAt(): string|null
    {
        return null;
    }
}
