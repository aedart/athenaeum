<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Rank Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\RankAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait RankTrait
{
    /**
     * The position in a hierarchy
     *
     * @var int|null
     */
    protected int|null $rank = null;

    /**
     * Set rank
     *
     * @param int|null $position The position in a hierarchy
     *
     * @return self
     */
    public function setRank(int|null $position): static
    {
        $this->rank = $position;

        return $this;
    }

    /**
     * Get rank
     *
     * If no rank value set, method
     * sets and returns a default rank.
     *
     * @see getDefaultRank()
     *
     * @return int|null rank or null if no rank has been set
     */
    public function getRank(): int|null
    {
        if (!$this->hasRank()) {
            $this->setRank($this->getDefaultRank());
        }
        return $this->rank;
    }

    /**
     * Check if rank has been set
     *
     * @return bool True if rank has been set, false if not
     */
    public function hasRank(): bool
    {
        return isset($this->rank);
    }

    /**
     * Get a default rank value, if any is available
     *
     * @return int|null Default rank value or null if no default value is available
     */
    public function getDefaultRank(): int|null
    {
        return null;
    }
}
