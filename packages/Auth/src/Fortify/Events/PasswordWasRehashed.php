<?php

namespace Aedart\Auth\Fortify\Events;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * @deprecated Since v8.x, password rehashing is now a default part of Laravel's \Illuminate\Contracts\Auth\UserProvider
 *
 * Password Was Rehashed Event
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Auth\Fortify\Events
 */
class PasswordWasRehashed
{
    use Dispatchable;

    /**
     * Creates a new "password was rehashed" event instance
     *
     * @param  Authenticatable  $user The authenticated user
     * @param  string  $hashed New hashed password
     */
    public function __construct(
        public readonly Authenticatable $user,
        public readonly string $hashed
    ) {
    }
}
