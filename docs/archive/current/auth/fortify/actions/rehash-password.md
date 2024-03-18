---
title: Rehash Password
description: Rehash Password If Needed Actions
sidebarDepth: 0
---

# Rehash Password If Needed

The `RehashPasswordIfNeeded` action is responsible for rehashing the user's password, when it is required.
Internally, the `Hasher` component is used for [determining if the password needs to be rehashed](https://laravel.com/docs/11.x/hashing#determining-if-a-password-needs-to-be-rehashed), as well as the actual rehashing.

::: warning Caution
While this action will rehash the user's password, it will **NOT SAVE** the new hashed password!
This must be done manually.
No assumptions are made regarding how to persist changes on the authenticated user (_[`Authenticatable` component](https://laravel.com/docs/11.x/authentication#the-authenticatable-contract)_). 

See [password rehashed event](#password-was-rehashed-event), for details.
:::

## How to use

The easiest way to enable this action, is by overwriting the default [authentication pipelines](https://laravel.com/docs/11.x/fortify#customizing-the-authentication-pipeline), in your `App\Providers\FortifyServiceProvider`.

```php{31}
use Aedart\Auth\Fortify\Actions\RehashPasswordIfNeeded;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;
use Illuminate\Http\Request;

class FortifyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // ...previous not shown...
        
        // Use custom authentication pipeline...
        Fortify::authenticateThrough(function (Request $request) {
            return array_filter([
                    config('fortify.limiters.login')
                        ? null
                        : EnsureLoginIsNotThrottled::class,

                    Features::enabled(Features::twoFactorAuthentication())
                        ? RedirectIfTwoFactorAuthenticatable::class
                        : null,

                    AttemptToAuthenticate::class,
                    PrepareAuthenticatedSession::class,
                    
                    // Add the rehash password action AFTER user was authenticated!
                    RehashPasswordIfNeeded::class
            ]);
        });
    }
    
    // ...remaining not shown...
}
```

## Password Was Rehashed Event

When the user's password is rehashed, the `PasswordWasRehashed` event is dispatched.
It contains the authenticated user and the rehashed password.
You can listen for this event and change your user's current password with a new one, as you see fit.

The following example assumes that an Eloquent Model is used as the application's `Authenticatable` user.

```php
// ...inside App\Providers\EventServiceProvider...

use Aedart\Auth\Fortify\Events\PasswordWasRehashed;
use Illuminate\Support\Facades\Event;

public function boot(): void
{ 
    Event::listen(function (PasswordWasRehashed $event) {
        $user = $event->user;
 
        $user->forceFill([
            'password' => $event->hashed // the new password hash!
        ])->save();
    });
}
```