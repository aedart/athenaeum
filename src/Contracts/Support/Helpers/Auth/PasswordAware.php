<?php

namespace Aedart\Contracts\Support\Helpers\Auth;

use Illuminate\Contracts\Auth\PasswordBroker;

/**
 * Password Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Auth
 */
interface PasswordAware
{
    /**
     * Set password
     *
     * @param PasswordBroker|null $broker Password Broker instance
     *
     * @return self
     */
    public function setPassword(?PasswordBroker $broker);

    /**
     * Get password
     *
     * If no password has been set, this method will
     * set and return a default password, if any such
     * value is available
     *
     * @see getDefaultPassword()
     *
     * @return PasswordBroker|null password or null if none password has been set
     */
    public function getPassword(): ?PasswordBroker;

    /**
     * Check if password has been set
     *
     * @return bool True if password has been set, false if not
     */
    public function hasPassword(): bool;

    /**
     * Get a default password value, if any is available
     *
     * @return PasswordBroker|null A default password value or Null if no default value is available
     */
    public function getDefaultPassword(): ?PasswordBroker;
}
