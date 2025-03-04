<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Last name Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\LastNameAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait LastNameTrait
{
    /**
     * Last Name (surname) or family name of a person
     *
     * @var string|null
     */
    protected string|null $lastName = null;

    /**
     * Set last name
     *
     * @param string|null $name Last Name (surname) or family name of a person
     *
     * @return self
     */
    public function setLastName(string|null $name): static
    {
        $this->lastName = $name;

        return $this;
    }

    /**
     * Get last name
     *
     * If no last name value set, method
     * sets and returns a default last name.
     *
     * @see getDefaultLastName()
     *
     * @return string|null last name or null if no last name has been set
     */
    public function getLastName(): string|null
    {
        if (!$this->hasLastName()) {
            $this->setLastName($this->getDefaultLastName());
        }
        return $this->lastName;
    }

    /**
     * Check if last name has been set
     *
     * @return bool True if last name has been set, false if not
     */
    public function hasLastName(): bool
    {
        return isset($this->lastName);
    }

    /**
     * Get a default last name value, if any is available
     *
     * @return string|null Default last name value or null if no default value is available
     */
    public function getDefaultLastName(): string|null
    {
        return null;
    }
}
