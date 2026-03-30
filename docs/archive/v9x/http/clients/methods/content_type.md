---
description: Setting the Accept & Content-Type Headers
sidebarDepth: 0
---

# Accept & Content-Type

The `withAccept()` and `withContentType()` are shortcut methods for setting the `Accept` and `Content-Type` headers.

## Accept

Use `withAccept()` to set the [Accept](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Accept) Http Header.  

```php
$builder = $client
        ->withAccept('text/xml');
```

## Content-Type

Use `withContentType()` to set your request's [Content-Type](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Type).

```php
$builder = $client
        ->withContentType('text/xml');
```  
