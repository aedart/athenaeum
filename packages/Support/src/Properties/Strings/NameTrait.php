<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Name Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\NameAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait NameTrait
{
    /**
     * Name
     *
     * @var string|null
     */
    protected string|null $name = null;

    /**
     * Set name
     *
     * @param string|null $name Name
     *
     * @return self
     */
    public function setName(string|null $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * If no name value set, method
     * sets and returns a default name.
     *
     * @see getDefaultName()
     *
     * @return string|null name or null if no name has been set
     */
    public function getName(): string|null
    {
        if (!$this->hasName()) {
            $this->setName($this->getDefaultName());
        }
        return $this->name;
    }

    /**
     * Check if name has been set
     *
     * @return bool True if name has been set, false if not
     */
    public function hasName(): bool
    {
        return isset($this->name);
    }

    /**
     * Get a default name value, if any is available
     *
     * @return string|null Default name value or null if no default value is available
     */
    public function getDefaultName(): string|null
    {
        return null;
    }
}
