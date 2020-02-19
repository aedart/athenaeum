<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Deleted at Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\DeletedAtAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait DeletedAtTrait
{
    /**
     * Date of when this component, entity or resource was deleted
     *
     * @var string|null
     */
    protected ?string $deletedAt = null;

    /**
     * Set deleted at
     *
     * @param string|null $date Date of when this component, entity or resource was deleted
     *
     * @return self
     */
    public function setDeletedAt(?string $date)
    {
        $this->deletedAt = $date;

        return $this;
    }

    /**
     * Get deleted at
     *
     * If no "deleted at" value set, method
     * sets and returns a default "deleted at".
     *
     * @see getDefaultDeletedAt()
     *
     * @return string|null deleted at or null if no deleted at has been set
     */
    public function getDeletedAt(): ?string
    {
        if (!$this->hasDeletedAt()) {
            $this->setDeletedAt($this->getDefaultDeletedAt());
        }
        return $this->deletedAt;
    }

    /**
     * Check if "deleted at" has been set
     *
     * @return bool True if "deleted at" has been set, false if not
     */
    public function hasDeletedAt(): bool
    {
        return isset($this->deletedAt);
    }

    /**
     * Get a default "deleted at" value, if any is available
     *
     * @return string|null Default "deleted at" value or null if no default value is available
     */
    public function getDefaultDeletedAt(): ?string
    {
        return null;
    }
}
