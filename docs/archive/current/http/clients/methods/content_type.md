---
description: Setting the Accept & Content-Type Headers
sidebarDepth: 0
---

# Accept & Content-Type

## Accept

To set the [Accept](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Accept) Http Header, use the `withAccept()` method.  

```php
$builder = $client
        ->withAccept('text/xml');
```

## Content-Type

Similarly, you can specify what your request's [Content-Type](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Type) is, with the `withContentType()` method.

```php
$builder = $client
        ->withContentType('text/xml');
```  
