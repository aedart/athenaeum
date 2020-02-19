<?php

namespace Aedart\Contracts\Support\Properties\Floats;

/**
 * Rank Aware
 *
 * Component is aware of float "rank"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Floats
 */
interface RankAware
{
    /**
     * Set rank
     *
     * @param float|null $position The position in a hierarchy
     *
     * @return self
     */
    public function setRank(?float $position);

    /**
     * Get rank
     *
     * If no "rank" value set, method
     * sets and returns a default "rank".
     *
     * @see getDefaultRank()
     *
     * @return float|null rank or null if no rank has been set
     */
    public function getRank(): ?float;

    /**
     * Check if "rank" has been set
     *
     * @return bool True if "rank" has been set, false if not
     */
    public function hasRank(): bool;

    /**
     * Get a default "rank" value, if any is available
     *
     * @return float|null Default "rank" value or null if no default value is available
     */
    public function getDefaultRank(): ?float;
}
