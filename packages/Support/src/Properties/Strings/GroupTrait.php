<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Group Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\GroupAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait GroupTrait
{
    /**
     * Group identifier
     *
     * @var string|null
     */
    protected string|null $group = null;

    /**
     * Set group
     *
     * @param string|null $identity Group identifier
     *
     * @return self
     */
    public function setGroup(string|null $identity): static
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
     * @return string|null group or null if no group has been set
     */
    public function getGroup(): string|null
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
     * @return string|null Default group value or null if no default value is available
     */
    public function getDefaultGroup(): string|null
    {
        return null;
    }
}
