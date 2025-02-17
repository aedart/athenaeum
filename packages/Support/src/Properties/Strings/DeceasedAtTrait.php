<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Deceased at Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\DeceasedAtAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait DeceasedAtTrait
{
    /**
     * Date of when person, animal of something has died
     *
     * @var string|null
     */
    protected string|null $deceasedAt = null;

    /**
     * Set deceased at
     *
     * @param string|null $date Date of when person, animal of something has died
     *
     * @return self
     */
    public function setDeceasedAt(string|null $date): static
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
     * @return string|null deceased at or null if no deceased at has been set
     */
    public function getDeceasedAt(): string|null
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
     * @return string|null Default deceased at value or null if no default value is available
     */
    public function getDefaultDeceasedAt(): string|null
    {
        return null;
    }
}
