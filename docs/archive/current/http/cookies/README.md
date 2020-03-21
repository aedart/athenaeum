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
Even so, it appears that there is a lack of packages, in which "cookie" objects are not stuffed with all kinds of additional behavioural or creational logic. 
This package attempts to keep these DTOs as simple as possible.
 