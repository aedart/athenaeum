<?php

namespace Aedart\Support\Helpers\Auth;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

/**
 * Auth Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Auth\AuthAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Auth
 */
trait AuthTrait
{
    /**
     * Access Guard instance
     *
     * @var Guard|null
     */
    protected ?Guard $auth = null;

    /**
     * Set auth
     *
     * @param Guard|null $guard Access Guard instance
     *
     * @return self
     */
    public function setAuth(?Guard $guard)
    {
        $this->auth = $guard;

        return $this;
    }

    /**
     * Get auth
     *
     * If no auth has been set, this method will
     * set and return a default auth, if any such
     * value is available
     *
     * @see getDefaultAuth()
     *
     * @return Guard|null auth or null if none auth has been set
     */
    public function getAuth(): ?Guard
    {
        if (!$this->hasAuth()) {
            $this->setAuth($this->getDefaultAuth());
        }
        return $this->auth;
    }

    /**
     * Check if auth has been set
     *
     * @return bool True if auth has been set, false if not
     */
    public function hasAuth(): bool
    {
        return isset($this->auth);
    }

    /**
     * Get a default auth value, if any is available
     *
     * @return Guard|null A default auth value or Null if no default value is available
     */
    public function getDefaultAuth(): ?Guard
    {
        $manager = Auth::getFacadeRoot();
        if (isset($manager)) {
            return $manager->guard();
        }
        return $manager;
    }
}
