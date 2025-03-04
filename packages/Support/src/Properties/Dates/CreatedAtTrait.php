<?php

namespace Aedart\Support\Properties\Dates;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Created at Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Dates\CreatedAtAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Dates
 */
trait CreatedAtTrait
{
    /**
     * Date of when this component, entity or resource was created
     *
     * @var \DateTimeInterface|null
     */
    protected \DateTimeInterface|null $createdAt = null;

    /**
     * Set created at
     *
     * @param \DateTimeInterface|null $date Date of when this component, entity or resource was created
     *
     * @return self
     */
    public function setCreatedAt(\DateTimeInterface|null $date): static
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
     * @return \DateTimeInterface|null created at or null if no created at has been set
     */
    public function getCreatedAt(): \DateTimeInterface|null
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
     * @return \DateTimeInterface|null Default created at value or null if no default value is available
     */
    public function getDefaultCreatedAt(): \DateTimeInterface|null
    {
        return null;
    }
}
