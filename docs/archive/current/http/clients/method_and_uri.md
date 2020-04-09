---
description: Setting the Http Method and Uri
sidebarDepth: 0
---

# Http Method and Uri

You can specify the Http method you wish to set on your next request, via `withMethod()`.
Doing so will allow you to omit the `$method` argument, in the `request()` method.
When combined with the `withUri()` method, you can also omit the `$uri` argument.

```php
$response = $client
        ->withMethod('GET')
        ->withUri('/users')
        ->request();
```

## Uri

`withUri()` accepts either a `string` uri or a [PSR-7](https://www.php-fig.org/psr/psr-7/) `UriInterface` instance as argument.

```php
use GuzzleHttp\Psr7\Uri;

$builder = $client
        ->withUri(new Uri('/users'));        
```
