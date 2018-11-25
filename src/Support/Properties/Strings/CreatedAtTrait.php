<?php

namespace Aedart\Support\Properties\Strings;

/**
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
    protected $createdAt = null;

    /**
     * Set created at
     *
     * @param string|null $date Date of when this component, entity or resource was created
     *
     * @return self
     */
    public function setCreatedAt(?string $date)
    {
        $this->createdAt = $date;

        return $this;
    }

    /**
     * Get created at
     *
     * If no "created at" value set, method
     * sets and returns a default "created at".
     *
     * @see getDefaultCreatedAt()
     *
     * @return string|null created at or null if no created at has been set
     */
    public function getCreatedAt() : ?string
    {
        if ( ! $this->hasCreatedAt()) {
            $this->setCreatedAt($this->getDefaultCreatedAt());
        }
        return $this->createdAt;
    }

    /**
     * Check if "created at" has been set
     *
     * @return bool True if "created at" has been set, false if not
     */
    public function hasCreatedAt() : bool
    {
        return isset($this->createdAt);
    }

    /**
     * Get a default "created at" value, if any is available
     *
     * @return string|null Default "created at" value or null if no default value is available
     */
    public function getDefaultCreatedAt() : ?string
    {
        return null;
    }
}
