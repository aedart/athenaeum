<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Rank Aware
 *
 * Component is aware of string "rank"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface RankAware
{
    /**
     * Set rank
     *
     * @param string|null $position The position in a hierarchy
     *
     * @return self
     */
    public function setRank(string|null $position): static;

    /**
     * Get rank
     *
     * If no rank value set, method
     * sets and returns a default rank.
     *
     * @see getDefaultRank()
     *
     * @return string|null rank or null if no rank has been set
     */
    public function getRank(): string|null;

    /**
     * Check if rank has been set
     *
     * @return bool True if rank has been set, false if not
     */
    public function hasRank(): bool;

    /**
     * Get a default rank value, if any is available
     *
     * @return string|null Default rank value or null if no default value is available
     */
    public function getDefaultRank(): string|null;
}
