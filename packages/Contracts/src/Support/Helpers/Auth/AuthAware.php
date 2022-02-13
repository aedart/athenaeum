<?php

namespace Aedart\Contracts\Support\Helpers\Auth;

use Illuminate\Contracts\Auth\Guard;

/**
 * Auth Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Auth
 */
interface AuthAware
{
    /**
     * Set auth
     *
     * @param Guard|null $guard Access Guard instance
     *
     * @return self
     */
    public function setAuth(Guard|null $guard): static;

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
    public function getAuth(): Guard|null;

    /**
     * Check if auth has been set
     *
     * @return bool True if auth has been set, false if not
     */
    public function hasAuth(): bool;

    /**
     * Get a default auth value, if any is available
     *
     * @return Guard|null A default auth value or Null if no default value is available
     */
    public function getDefaultAuth(): Guard|null;
}
