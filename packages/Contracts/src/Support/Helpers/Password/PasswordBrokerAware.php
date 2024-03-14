<?php

namespace Aedart\Contracts\Support\Helpers\Password;

use Illuminate\Contracts\Auth\PasswordBroker;

/**
 * Password Broker Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Password
 */
interface PasswordBrokerAware
{
    /**
     * Set password broker
     *
     * @param  PasswordBroker|null  $broker  Password Broker instance
     *
     * @return self
     */
    public function setPasswordBroker(PasswordBroker|null $broker): static;

    /**
     * Get password broker
     *
     * If no password broker has been set, this method will
     * set and return a default password broker, if any such
     * value is available
     *
     * @return PasswordBroker|null password broker or null if none password broker has been set
     */
    public function getPasswordBroker(): PasswordBroker|null;

    /**
     * Check if password broker has been set
     *
     * @return bool True if password broker has been set, false if not
     */
    public function hasPasswordBroker(): bool;

    /**
     * Get a default password broker value, if any is available
     *
     * @return PasswordBroker|null A default password broker value or Null if no default value is available
     */
    public function getDefaultPasswordBroker(): PasswordBroker|null;
}
