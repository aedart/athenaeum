---
description: Password Reset Link Failure Exception
sidebarDepth: 0
---

# Password Reset Link Failure

The `PasswordResetLinkFailure`¹ exception can be used as an alternative to Laravel Fortify's default validation exception,
in situations [requesting a password reset link](https://laravel.com/docs/13.x/fortify#requesting-a-password-reset-link)
fails, e.g. due to invalid user credential.

The exception results in an HTTP ["200 Ok"](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/200) response, rather
than the default ["422 Unprocessable Content"](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/422) response.
Doing so can reduce the chance, that an attacker is able to guess whether a user account exists or not.
For more information about such, please see the custom
["failed password reset link" API response](../responses/failed-pass-reset-link.md).

¹: _Full namespace: `\Aedart\Auth\Fortify\Exceptions\PasswordResetLinkFailure`._