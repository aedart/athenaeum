<?php

namespace Aedart\Support\Helpers\Password;

use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Support\Facades\Password;

/**
 * Password Broker Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Password\PasswordBrokerAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Password
 */
trait PasswordBrokerTrait
{
    /**
     * Password Broker instance
     *
     * @var PasswordBroker|null
     */
    protected PasswordBroker|null $passwordBroker = null;

    /**
     * Set password broker
     *
     * @param  PasswordBroker|null  $broker  Password Broker instance
     *
     * @return self
     */
    public function setPasswordBroker(PasswordBroker|null $broker): static
    {
        $this->passwordBroker = $broker;

        return $this;
    }

    /**
     * Get password broker
     *
     * If no password broker has been set, this method will
     * set and return a default password broker, if any such
     * value is available
     *
     * @return PasswordBroker|null password broker or null if none password broker has been set
     */
    public function getPasswordBroker(): PasswordBroker|null
    {
        if (!$this->hasPasswordBroker()) {
            $this->setPasswordBroker($this->getDefaultPasswordBroker());
        }
        return $this->passwordBroker;
    }

    /**
     * Check if password broker has been set
     *
     * @return bool True if password broker has been set, false if not
     */
    public function hasPasswordBroker(): bool
    {
        return isset($this->passwordBroker);
    }

    /**
     * Get a default password broker value, if any is available
     *
     * @return PasswordBroker|null A default password broker value or Null if no default value is available
     */
    public function getDefaultPasswordBroker(): PasswordBroker|null
    {
        return Password::getFacadeRoot()?->broker();
    }
}
