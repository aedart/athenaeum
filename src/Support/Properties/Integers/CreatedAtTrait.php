<?php

namespace Aedart\Support\Properties\Integers;

/**
 * Created at Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\CreatedAtAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait CreatedAtTrait
{
    /**
     * Date of when this component, entity or resource was created
     *
     * @var int|null
     */
    protected $createdAt = null;

    /**
     * Set created at
     *
     * @param int|null $date Date of when this component, entity or resource was created
     *
     * @return self
     */
    public function setCreatedAt(?int $date)
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
     * @return int|null created at or null if no created at has been set
     */
    public function getCreatedAt() : ?int
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
     * @return int|null Default "created at" value or null if no default value is available
     */
    public function getDefaultCreatedAt() : ?int
    {
        return null;
    }
}
