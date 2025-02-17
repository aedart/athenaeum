<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
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
    protected int|null $group = null;

    /**
     * Set group
     *
     * @param int|null $identity Group identifier
     *
     * @return self
     */
    public function setGroup(int|null $identity): static
    {
        $this->group = $identity;

        return $this;
    }

    /**
     * Get group
     *
     * If no group value set, method
     * sets and returns a default group.
     *
     * @see getDefaultGroup()
     *
     * @return int|null group or null if no group has been set
     */
    public function getGroup(): int|null
    {
        if (!$this->hasGroup()) {
            $this->setGroup($this->getDefaultGroup());
        }
        return $this->group;
    }

    /**
     * Check if group has been set
     *
     * @return bool True if group has been set, false if not
     */
    public function hasGroup(): bool
    {
        return isset($this->group);
    }

    /**
     * Get a default group value, if any is available
     *
     * @return int|null Default group value or null if no default value is available
     */
    public function getDefaultGroup(): int|null
    {
        return null;
    }
}
