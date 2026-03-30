---
title: Failed Password Reset Link 
description: Failed Password Reset Link API Response
sidebarDepth: 0
---

# Failed Password Reset Link (API Response)

In an edge case scenario, a ["forgot password"](https://laravel.com/docs/13.x/fortify#requesting-a-password-reset-link)
mechanism can potentially be misused to guess if a user account exists or not. Most commonly, this is done so by
requesting a password reset, to a specified email. When your application responds with a
[successful response](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#successful_responses) for a valid email,
attackers will know that an account exists and proceed to exploitation attempts.  

::: tip Note
The above described edge case scenario is **NOT** specifically tied to Laravel Fortify. Any kind of "reset password"
functionality _can be_ subject to such, if end-users are able to request a reset password link.

See [Testing for Account Enumeration and Guessable User Account](https://owasp.org/www-project-web-security-testing-guide/stable/4-Web_Application_Security_Testing/03-Identity_Management_Testing/04-Testing_for_Account_Enumeration_and_Guessable_User_Account.html)
for additional details.
:::

To reduce the chances of revealing the existence of a user account, when requesting a reset link, the
`FailedPasswordResetLinkApiResponse` can be used. Whenever the requested username, e.g. email, does not exist, the
component throws a ["password reset link failure"](../exceptions/pass-reset-link-failure.md) exception, which results in
an HTTP ["200 Ok"](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/200) response. An attacker will then no
longer be able to tell the difference between a valid or invalid username.

::: warning Limitations
The `FailedPasswordResetLinkApiResponse` is intended for API driven login mechanisms, e.g. when your "request reset
password" functionality is implemented via a JSON based API.
:::

## How to use

To use the custom API response, register a singleton binding for the `FailedPasswordResetLinkRequestResponse` interface.

```php
namespace App\Providers;

use Aedart\Auth\Fortify\Responses\FailedPasswordResetLinkApiResponse;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Fortify\Contracts\FailedPasswordResetLinkRequestResponse;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(
            FailedPasswordResetLinkRequestResponse::class,
            FailedPasswordResetLinkApiResponse::class
        );
    }
}
```

## Additional Reading

* [Forgot Password Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Forgot_Password_Cheat_Sheet.html).
* [Exploring Password Reset Vulnerabilities and Security Best Practices](https://www.vaadata.com/blog/exploring-password-reset-vulnerabilities-and-security-best-practices/)
* [Exploring Reset Password Vulnerabilities: Risks, Exploits, and Prevention Strategies](https://medium.com/@cuncis/exploring-reset-password-vulnerabilities-risks-exploits-and-prevention-strategies-87745b65dd66)