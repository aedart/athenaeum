<?php

namespace Aedart\Contracts\Support\Helpers\Password;

use Illuminate\Contracts\Auth\PasswordBrokerFactory;

/**
 * Password Broker Manager Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Password
 */
interface PasswordBrokerManagerAware
{
    /**
     * Set password broker manager
     *
     * @param  PasswordBrokerFactory|null  $manager  Password Broker Manager instance
     *
     * @return self
     */
    public function setPasswordBrokerManager(PasswordBrokerFactory|null $manager): static;

    /**
     * Get password broker manager
     *
     * If no password broker manager has been set, this method will
     * set and return a default password broker manager, if any such
     * value is available
     *
     * @return PasswordBrokerFactory|null password broker manager or null if none password broker manager has been set
     */
    public function getPasswordBrokerManager(): PasswordBrokerFactory|null;

    /**
     * Check if password broker manager has been set
     *
     * @return bool True if password broker manager has been set, false if not
     */
    public function hasPasswordBrokerManager(): bool;

    /**
     * Get a default password broker manager value, if any is available
     *
     * @return PasswordBrokerFactory|null A default password broker manager value or Null if no default value is available
     */
    public function getDefaultPasswordBrokerManager(): PasswordBrokerFactory|null;
}
