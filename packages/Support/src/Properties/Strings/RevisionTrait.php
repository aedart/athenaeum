<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Revision Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\RevisionAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait RevisionTrait
{
    /**
     * A revision, batch number or other identifier
     *
     * @var string|null
     */
    protected string|null $revision = null;

    /**
     * Set revision
     *
     * @param string|null $revision A revision, batch number or other identifier
     *
     * @return self
     */
    public function setRevision(string|null $revision): static
    {
        $this->revision = $revision;

        return $this;
    }

    /**
     * Get revision
     *
     * If no revision value set, method
     * sets and returns a default revision.
     *
     * @see getDefaultRevision()
     *
     * @return string|null revision or null if no revision has been set
     */
    public function getRevision(): string|null
    {
        if (!$this->hasRevision()) {
            $this->setRevision($this->getDefaultRevision());
        }
        return $this->revision;
    }

    /**
     * Check if revision has been set
     *
     * @return bool True if revision has been set, false if not
     */
    public function hasRevision(): bool
    {
        return isset($this->revision);
    }

    /**
     * Get a default revision value, if any is available
     *
     * @return string|null Default revision value or null if no default value is available
     */
    public function getDefaultRevision(): string|null
    {
        return null;
    }
}
