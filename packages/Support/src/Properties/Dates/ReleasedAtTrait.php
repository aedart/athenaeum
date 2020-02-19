<?php

namespace Aedart\Support\Properties\Dates;

/**
 * Released at Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Dates\ReleasedAtAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Dates
 */
trait ReleasedAtTrait
{
    /**
     * Date of when this component, entity or something was released
     *
     * @var \DateTime|null
     */
    protected ?\DateTime $releasedAt = null;

    /**
     * Set released at
     *
     * @param \DateTime|null $date Date of when this component, entity or something was released
     *
     * @return self
     */
    public function setReleasedAt(?\DateTime $date)
    {
        $this->releasedAt = $date;

        return $this;
    }

    /**
     * Get released at
     *
     * If no "released at" value set, method
     * sets and returns a default "released at".
     *
     * @see getDefaultReleasedAt()
     *
     * @return \DateTime|null released at or null if no released at has been set
     */
    public function getReleasedAt(): ?\DateTime
    {
        if (!$this->hasReleasedAt()) {
            $this->setReleasedAt($this->getDefaultReleasedAt());
        }
        return $this->releasedAt;
    }

    /**
     * Check if "released at" has been set
     *
     * @return bool True if "released at" has been set, false if not
     */
    public function hasReleasedAt(): bool
    {
        return isset($this->releasedAt);
    }

    /**
     * Get a default "released at" value, if any is available
     *
     * @return \DateTime|null Default "released at" value or null if no default value is available
     */
    public function getDefaultReleasedAt(): ?\DateTime
    {
        return null;
    }
}
