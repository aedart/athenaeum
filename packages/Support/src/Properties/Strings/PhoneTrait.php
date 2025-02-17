<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Phone Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\PhoneAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait PhoneTrait
{
    /**
     * Phone number
     *
     * @var string|null
     */
    protected string|null $phone = null;

    /**
     * Set phone
     *
     * @param string|null $number Phone number
     *
     * @return self
     */
    public function setPhone(string|null $number): static
    {
        $this->phone = $number;

        return $this;
    }

    /**
     * Get phone
     *
     * If no phone value set, method
     * sets and returns a default phone.
     *
     * @see getDefaultPhone()
     *
     * @return string|null phone or null if no phone has been set
     */
    public function getPhone(): string|null
    {
        if (!$this->hasPhone()) {
            $this->setPhone($this->getDefaultPhone());
        }
        return $this->phone;
    }

    /**
     * Check if phone has been set
     *
     * @return bool True if phone has been set, false if not
     */
    public function hasPhone(): bool
    {
        return isset($this->phone);
    }

    /**
     * Get a default phone value, if any is available
     *
     * @return string|null Default phone value or null if no default value is available
     */
    public function getDefaultPhone(): string|null
    {
        return null;
    }
}
