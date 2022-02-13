<?php

namespace Aedart\Support\Helpers\Auth;

use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Support\Facades\Password;

/**
 * Password Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Auth\PasswordAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Auth
 */
trait PasswordTrait
{
    /**
     * Password Broker instance
     *
     * @var PasswordBroker|null
     */
    protected PasswordBroker|null $password = null;

    /**
     * Set password
     *
     * @param PasswordBroker|null $broker Password Broker instance
     *
     * @return self
     */
    public function setPassword(PasswordBroker|null $broker): static
    {
        $this->password = $broker;

        return $this;
    }

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
    public function getPassword(): PasswordBroker|null
    {
        if (!$this->hasPassword()) {
            $this->setPassword($this->getDefaultPassword());
        }
        return $this->password;
    }

    /**
     * Check if password has been set
     *
     * @return bool True if password has been set, false if not
     */
    public function hasPassword(): bool
    {
        return isset($this->password);
    }

    /**
     * Get a default password value, if any is available
     *
     * @return PasswordBroker|null A default password value or Null if no default value is available
     */
    public function getDefaultPassword(): PasswordBroker|null
    {
        $manager = Password::getFacadeRoot();
        if (isset($manager)) {
            return $manager->broker();
        }
        return $manager;
    }
}
