<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Middle name Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\MiddleNameAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait MiddleNameTrait
{
    /**
     * Middle Name or names of a person
     *
     * @var string|null
     */
    protected string|null $middleName = null;

    /**
     * Set middle name
     *
     * @param string|null $name Middle Name or names of a person
     *
     * @return self
     */
    public function setMiddleName(string|null $name): static
    {
        $this->middleName = $name;

        return $this;
    }

    /**
     * Get middle name
     *
     * If no middle name value set, method
     * sets and returns a default middle name.
     *
     * @see getDefaultMiddleName()
     *
     * @return string|null middle name or null if no middle name has been set
     */
    public function getMiddleName(): string|null
    {
        if (!$this->hasMiddleName()) {
            $this->setMiddleName($this->getDefaultMiddleName());
        }
        return $this->middleName;
    }

    /**
     * Check if middle name has been set
     *
     * @return bool True if middle name has been set, false if not
     */
    public function hasMiddleName(): bool
    {
        return isset($this->middleName);
    }

    /**
     * Get a default middle name value, if any is available
     *
     * @return string|null Default middle name value or null if no default value is available
     */
    public function getDefaultMiddleName(): string|null
    {
        return null;
    }
}
