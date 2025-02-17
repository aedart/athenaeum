<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Revision Aware
 *
 * Component is aware of string "revision"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface RevisionAware
{
    /**
     * Set revision
     *
     * @param string|null $revision A revision, batch number or other identifier
     *
     * @return self
     */
    public function setRevision(string|null $revision): static;

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
    public function getRevision(): string|null;

    /**
     * Check if revision has been set
     *
     * @return bool True if revision has been set, false if not
     */
    public function hasRevision(): bool;

    /**
     * Get a default revision value, if any is available
     *
     * @return string|null Default revision value or null if no default value is available
     */
    public function getDefaultRevision(): string|null;
}
