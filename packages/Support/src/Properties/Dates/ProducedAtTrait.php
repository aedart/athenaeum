<?php

namespace Aedart\Support\Properties\Dates;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Produced at Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Dates\ProducedAtAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Dates
 */
trait ProducedAtTrait
{
    /**
     * Date of when this component, entity or something was produced
     *
     * @var \DateTimeInterface|null
     */
    protected \DateTimeInterface|null $producedAt = null;

    /**
     * Set produced at
     *
     * @param \DateTimeInterface|null $date Date of when this component, entity or something was produced
     *
     * @return self
     */
    public function setProducedAt(\DateTimeInterface|null $date): static
    {
        $this->producedAt = $date;

        return $this;
    }

    /**
     * Get produced at
     *
     * If no produced at value set, method
     * sets and returns a default produced at.
     *
     * @see getDefaultProducedAt()
     *
     * @return \DateTimeInterface|null produced at or null if no produced at has been set
     */
    public function getProducedAt(): \DateTimeInterface|null
    {
        if (!$this->hasProducedAt()) {
            $this->setProducedAt($this->getDefaultProducedAt());
        }
        return $this->producedAt;
    }

    /**
     * Check if produced at has been set
     *
     * @return bool True if produced at has been set, false if not
     */
    public function hasProducedAt(): bool
    {
        return isset($this->producedAt);
    }

    /**
     * Get a default produced at value, if any is available
     *
     * @return \DateTimeInterface|null Default produced at value or null if no default value is available
     */
    public function getDefaultProducedAt(): \DateTimeInterface|null
    {
        return null;
    }
}
