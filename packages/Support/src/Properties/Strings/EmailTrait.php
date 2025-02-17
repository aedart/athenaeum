<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Email Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\EmailAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait EmailTrait
{
    /**
     * Email
     *
     * @var string|null
     */
    protected string|null $email = null;

    /**
     * Set email
     *
     * @param string|null $email Email
     *
     * @return self
     */
    public function setEmail(string|null $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * If no email value set, method
     * sets and returns a default email.
     *
     * @see getDefaultEmail()
     *
     * @return string|null email or null if no email has been set
     */
    public function getEmail(): string|null
    {
        if (!$this->hasEmail()) {
            $this->setEmail($this->getDefaultEmail());
        }
        return $this->email;
    }

    /**
     * Check if email has been set
     *
     * @return bool True if email has been set, false if not
     */
    public function hasEmail(): bool
    {
        return isset($this->email);
    }

    /**
     * Get a default email value, if any is available
     *
     * @return string|null Default email value or null if no default value is available
     */
    public function getDefaultEmail(): string|null
    {
        return null;
    }
}
