<?php

namespace Aedart\Support\Properties\Dates;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Deceased at Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Dates\DeceasedAtAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Dates
 */
trait DeceasedAtTrait
{
    /**
     * Date of when person, animal of something has died
     *
     * @var \DateTimeInterface|null
     */
    protected \DateTimeInterface|null $deceasedAt = null;

    /**
     * Set deceased at
     *
     * @param \DateTimeInterface|null $date Date of when person, animal of something has died
     *
     * @return self
     */
    public function setDeceasedAt(\DateTimeInterface|null $date): static
    {
        $this->deceasedAt = $date;

        return $this;
    }

    /**
     * Get deceased at
     *
     * If no deceased at value set, method
     * sets and returns a default deceased at.
     *
     * @see getDefaultDeceasedAt()
     *
     * @return \DateTimeInterface|null deceased at or null if no deceased at has been set
     */
    public function getDeceasedAt(): \DateTimeInterface|null
    {
        if (!$this->hasDeceasedAt()) {
            $this->setDeceasedAt($this->getDefaultDeceasedAt());
        }
        return $this->deceasedAt;
    }

    /**
     * Check if deceased at has been set
     *
     * @return bool True if deceased at has been set, false if not
     */
    public function hasDeceasedAt(): bool
    {
        return isset($this->deceasedAt);
    }

    /**
     * Get a default deceased at value, if any is available
     *
     * @return \DateTimeInterface|null Default deceased at value or null if no default value is available
     */
    public function getDefaultDeceasedAt(): \DateTimeInterface|null
    {
        return null;
    }
}
