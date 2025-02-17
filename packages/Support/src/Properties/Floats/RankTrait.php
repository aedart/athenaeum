<?php

namespace Aedart\Support\Properties\Floats;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Rank Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Floats\RankAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Floats
 */
trait RankTrait
{
    /**
     * The position in a hierarchy
     *
     * @var float|null
     */
    protected float|null $rank = null;

    /**
     * Set rank
     *
     * @param float|null $position The position in a hierarchy
     *
     * @return self
     */
    public function setRank(float|null $position): static
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
     * @return float|null rank or null if no rank has been set
     */
    public function getRank(): float|null
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
     * @return float|null Default rank value or null if no default value is available
     */
    public function getDefaultRank(): float|null
    {
        return null;
    }
}
