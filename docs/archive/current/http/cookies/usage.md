---
description: How to use Http Cookies
---

# Usage

There are two DTOs that you can choose from; `Cookie` and `SetCookie`.

## Cookie

The `Cookie` object only contains a `name` and `value` property.

```php
<?php
use Aedart\Http\Cookies\Cookie;

$cookie = new Cookie([
    'name' => 'my_cookie',
    'value' => 'sweet'
]);
```

See [mozilla.org](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cookie) for additional information about what the `Cookie` DTO is intended to represent.

## Set-Cookie

The `SetCookie` is an extended version of the `Cookie` DTO.
It offers the following properties

- `name`: Cookie name
- `value`: Cookie value
- `expires`: Maximum lifetime of the cookie
- `maxAge`: Number of seconds until the cookie expires.
- `domain`: Hosts to where the cookie will be sent
- `path`: Path that must exist on the requested url
- `secure`: State of whether the cookie should be sent via https
- `httpOnly`: Whether accessing the cookie is forbidden via JavaScript, or not.
- `sameSite`: whether cookie should be available for cross-site requests

```php
<?php
use Aedart\Contracts\Http\Cookies\SameSite;
use Aedart\Http\Cookies\SetCookie;

$cookie = new SetCookie([
    'name' => 'my_cookie',
    'value' => 'sweet',
    'expires' => null, // null, timestamp or RFC7231 Formatted string date 
    'maxAge' => 60 * 5,
    'domain' => null,
    'path' => '/',
    'secure' => true,
    'httpOnly' => false,
    'sameSite' => SameSite::LAX
]);
```

See [mozilla.org](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie) for additional information about what the `SetCookie` DTO is intended to represent.

## Populate

The Cookie DTOs can be populated from an array, via the `popualte()` method.

```php
$cookie->populate([
    'name' => 'my_other_cookie'
]);

echo $cookie->getName(); // "my_other_cookie"
```

## Export to Array

Both DTOs are able to export their properties to an array, via the `toArray()` method.

```php
$data = $cookie->toArray();
```

## Onward

Please review the source code of these DTOs, for additional information.
Feel free to extend these components and offer more functionality, should your application require such.  