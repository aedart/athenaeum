<?php

namespace Aedart\Auth\Fortify\Actions;

use Aedart\Auth\Fortify\Events\PasswordWasRehashed;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\Request;

/**
 * @deprecated Since v8.x, password rehashing is now a default part of Laravel's \Illuminate\Contracts\Auth\UserProvider
 *
 * Rehash Password If Needed Action
 *
 * If needed, this action will re-hash submitted plain-text password and notify
 * system with new hashed password. The action DOES NOT save the new password
 * for the user!
 *
 * @see PasswordWasRehashed
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Auth\Fortify\Actions
 */
class RehashPasswordIfNeeded
{
    /**
     * Creates a new action instance
     *
     * @param  StatefulGuard  $guard
     * @param  Hasher  $hasher
     * @param  string  $key  [optional] Name of the input key that holds the plain-text
     *                       password in the request
     */
    public function __construct(
        protected StatefulGuard $guard,
        protected Hasher $hasher,
        protected string $key = 'password'
    ) {
    }

    /**
     * Rehashes user's password, if needed
     *
     * @param  Request  $request
     * @param  callable  $next
     *
     * @return mixed
     */
    public function handle(Request $request, callable $next): mixed
    {
        $user = $this->user();
        if (!isset($user)) {
            return $next($request);
        }

        // Caution: here the plain-text password is rehashed. But, it is
        // NOT automatically saved for the user. We only notify the system
        // with a new password hash!
        if ($this->needsRehash($user->getAuthPassword())) {
            $hashed = $this->hashPassword($request->input($this->key));
            $this->notify($user, $hashed);
        }

        return $next($request);
    }

    /**
     * Notify that user's password has been rehashed
     *
     * @param  Authenticatable  $user
     * @param  string  $hashed
     *
     * @return void
     */
    protected function notify(Authenticatable $user, string $hashed): void
    {
        PasswordWasRehashed::dispatch($user, $hashed);
    }

    /**
     * Hash the given plain-text password
     *
     * @param  string  $plain
     *
     * @return string
     */
    protected function hashPassword(string $plain): string
    {
        return $this->hasher->make($plain);
    }

    /**
     * Determine if hashed value needs to be rehashed
     *
     * @param  string  $hashedPassword
     *
     * @return bool
     */
    protected function needsRehash(string $hashedPassword): bool
    {
        return $this->hasher->needsRehash($hashedPassword);
    }

    /**
     * Returns current authenticated user
     *
     * @return Authenticatable|null
     */
    protected function user(): Authenticatable|null
    {
        return $this->guard->user();
    }
}
