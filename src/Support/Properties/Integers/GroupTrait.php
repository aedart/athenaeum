<?php

namespace Aedart\Support\Properties\Integers;

/**
 * Group Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\GroupAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait GroupTrait
{
    /**
     * Group identifier
     *
     * @var int|null
     */
    protected ?int $group = null;

    /**
     * Set group
     *
     * @param int|null $identity Group identifier
     *
     * @return self
     */
    public function setGroup(?int $identity)
    {
        $this->group = $identity;

        return $this;
    }

    /**
     * Get group
     *
     * If no "group" value set, method
     * sets and returns a default "group".
     *
     * @see getDefaultGroup()
     *
     * @return int|null group or null if no group has been set
     */
    public function getGroup() : ?int
    {
        if ( ! $this->hasGroup()) {
            $this->setGroup($this->getDefaultGroup());
        }
        return $this->group;
    }

    /**
     * Check if "group" has been set
     *
     * @return bool True if "group" has been set, false if not
     */
    public function hasGroup() : bool
    {
        return isset($this->group);
    }

    /**
     * Get a default "group" value, if any is available
     *
     * @return int|null Default "group" value or null if no default value is available
     */
    public function getDefaultGroup() : ?int
    {
        return null;
    }
}
