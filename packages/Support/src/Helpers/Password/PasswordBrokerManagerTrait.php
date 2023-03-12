<?php

namespace Aedart\Support\Helpers\Password;

use Illuminate\Contracts\Auth\PasswordBrokerFactory;
use Illuminate\Support\Facades\Password;

/**
 * Password Broker Manager Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Password\PasswordBrokerManagerAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Password
 */
trait PasswordBrokerManagerTrait
{
    /**
     * Password Broker Manager instance
     *
     * @var PasswordBrokerFactory|null
     */
    protected PasswordBrokerFactory|null $passwordBrokerManager = null;

    /**
     * Set password broker manager
     *
     * @param  PasswordBrokerFactory|null  $manager  Password Broker Manager instance
     *
     * @return self
     */
    public function setPasswordBrokerManager(PasswordBrokerFactory|null $manager): static
    {
        $this->passwordBrokerManager = $manager;

        return $this;
    }

    /**
     * Get password broker manager
     *
     * If no password broker manager has been set, this method will
     * set and return a default password broker manager, if any such
     * value is available
     *
     * @return PasswordBrokerFactory|null password broker manager or null if none password broker manager has been set
     */
    public function getPasswordBrokerManager(): PasswordBrokerFactory|null
    {
        if (!$this->hasPasswordBrokerManager()) {
            $this->setPasswordBrokerManager($this->getDefaultPasswordBrokerManager());
        }
        return $this->passwordBrokerManager;
    }

    /**
     * Check if password broker manager has been set
     *
     * @return bool True if password broker manager has been set, false if not
     */
    public function hasPasswordBrokerManager(): bool
    {
        return isset($this->passwordBrokerManager);
    }

    /**
     * Get a default password broker manager value, if any is available
     *
     * @return PasswordBrokerFactory|null A default password broker manager value or Null if no default value is available
     */
    public function getDefaultPasswordBrokerManager(): PasswordBrokerFactory|null
    {
        return Password::getFacadeRoot();
    }
}
