<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * First name Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\FirstNameAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait FirstNameTrait
{
    /**
     * First name (given name) or forename of a person
     *
     * @var string|null
     */
    protected string|null $firstName = null;

    /**
     * Set first name
     *
     * @param string|null $name First name (given name) or forename of a person
     *
     * @return self
     */
    public function setFirstName(string|null $name): static
    {
        $this->firstName = $name;

        return $this;
    }

    /**
     * Get first name
     *
     * If no first name value set, method
     * sets and returns a default first name.
     *
     * @see getDefaultFirstName()
     *
     * @return string|null first name or null if no first name has been set
     */
    public function getFirstName(): string|null
    {
        if (!$this->hasFirstName()) {
            $this->setFirstName($this->getDefaultFirstName());
        }
        return $this->firstName;
    }

    /**
     * Check if first name has been set
     *
     * @return bool True if first name has been set, false if not
     */
    public function hasFirstName(): bool
    {
        return isset($this->firstName);
    }

    /**
     * Get a default first name value, if any is available
     *
     * @return string|null Default first name value or null if no default value is available
     */
    public function getDefaultFirstName(): string|null
    {
        return null;
    }
}
