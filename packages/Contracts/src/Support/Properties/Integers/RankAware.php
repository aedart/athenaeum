<?php

namespace Aedart\Contracts\Support\Properties\Integers;

/**
 * Rank Aware
 *
 * Component is aware of int "rank"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Integers
 */
interface RankAware
{
    /**
     * Set rank
     *
     * @param int|null $position The position in a hierarchy
     *
     * @return self
     */
    public function setRank(?int $position);

    /**
     * Get rank
     *
     * If no "rank" value set, method
     * sets and returns a default "rank".
     *
     * @see getDefaultRank()
     *
     * @return int|null rank or null if no rank has been set
     */
    public function getRank(): ?int;

    /**
     * Check if "rank" has been set
     *
     * @return bool True if "rank" has been set, false if not
     */
    public function hasRank(): bool;

    /**
     * Get a default "rank" value, if any is available
     *
     * @return int|null Default "rank" value or null if no default value is available
     */
    public function getDefaultRank(): ?int;
}
