---
description: About the Http Cookies Package
---

# Http Cookies

Provides very simple [DTOs](https://en.wikipedia.org/wiki/Data_transfer_object) for [Http Cookie](https://en.wikipedia.org/wiki/HTTP_cookie).
These DTOs do not offer any "advanced" capabilities to send Http [Cookie headers](https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies), nor to be populated from a [Request](https://www.php-fig.org/psr/psr-7/) / [Response](https://www.php-fig.org/psr/psr-7/) objects, or from `Cookie` Http headers.
They are nothing more than data placeholders.
Feel free to extend them with whatever logic your application might require.

## Examples

```php
<?php
use Aedart\Http\Cookies\Cookie;

$cookie = new Cookie([
    'name' => 'my_cookie',
    'value' => 'sweet'
]);
```

```php
<?php
use Aedart\Http\Cookies\SetCookie;

$cookie = new SetCookie([
    'name' => 'my_cookie',
    'value' => 'sweet',
    'maxAge' => 60 * 5,
    'secure' => true
]);
```

## Motivation

At the time of this writing, when searching for [packages](https://packagist.org/?query=cookies) that contain the keyword "cookie", there seems to be an abundance of vendors.
Many of them appear to have "cookie" objects with all kinds of behavioural or creational logic, each serving their respectful purpose.
Unfortunately, it can be difficult to reuse some of those packages, without introducing various side-effects, such as additional behavioural logic that might not be favourable in certain circumstances.

For the above mentioned reason, this package was created, in hopes to offer only the data-placeholder aspects for Http Cookies.
How you choose to use these, is entirely up to you. 