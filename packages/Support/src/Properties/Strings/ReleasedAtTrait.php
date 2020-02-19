<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Released at Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\ReleasedAtAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait ReleasedAtTrait
{
    /**
     * Date of when this component, entity or something was released
     *
     * @var string|null
     */
    protected ?string $releasedAt = null;

    /**
     * Set released at
     *
     * @param string|null $date Date of when this component, entity or something was released
     *
     * @return self
     */
    public function setReleasedAt(?string $date)
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
     * @return string|null released at or null if no released at has been set
     */
    public function getReleasedAt(): ?string
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
     * @return string|null Default "released at" value or null if no default value is available
     */
    public function getDefaultReleasedAt(): ?string
    {
        return null;
    }
}
