---
description: Failed Login Attempt Exception
sidebarDepth: 0
---

# Failed Login Attempt

The `FailedLoginAttempt` exception is an alternative to Laravel's default validation exception that is thrown, on
unsuccessful login attempts. The custom exception ensures that an HTTP
["401 Unauthorized"](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/401) response is sent back to a client,
instead of a ["422 Unprocessable Content"](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/422). 

The exception can be used in combination with a custom "attempt to authenticate" action (_see example below_).

```php
use Aedart\Auth\Fortify\Exceptions\FailedLoginAttempt;
use Laravel\Fortify\Actions\AttemptToAuthenticate as BaseAttemptToAuthenticate;
use Laravel\Fortify\Fortify;

class AttemptToAuthenticate extends BaseAttemptToAuthenticate
{
    protected function throwFailedAuthenticationException($request)
    {
        $this->limiter->increment($request);

        throw FailedLoginAttempt::withMessages([
            Fortify::username() => [trans('auth.failed')],
        ]);
    }
}
```

To use such an action, you will have to modify Laravel Fortify's default
[authentication pipeline](https://laravel.com/docs/12.x/fortify#customizing-the-authentication-pipeline).

```php
Fortify::authenticateThrough(function (Request $request) {
    return array_filter([
        // ...previous actions not shown...
        
        AttemptToAuthenticate::class,
        PrepareAuthenticatedSession::class,
    ]);
});
```