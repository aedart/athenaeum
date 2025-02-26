---
description: Request Cookies
sidebarDepth: 0
---

# Cookies

[[TOC]]

## Add Cookie

The `addCookie()` method allows you to add a Http [Cookie](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cookie) header, to your request. 
It accepts two arguments:

- `$name`: `string` Cookie's name
- `$value`: `string` (_optional_) value

```php
$response = $client
        ->addCookie('foo', 'bar')
        ->get('/users');
```

## Alternative Methods

When using the `withCookie()` method, you can add a cookie via a callback.
The callback is provided with a [Cookie](../../cookies/) instance.

```php
use Aedart\Contracts\Http\Cookies\Cookie;

$response = $client
        ->withCookie(function(Cookie $cookie){
            $cookie
                ->name('foo')
                ->value('bar');
        })
        ->get('/profile-data');
```

### Multiple Cookies

`withCookies()` accepts an array of callbacks or `Cookie` instances. 

```php
use Aedart\Contracts\Http\Cookies\Cookie;

$response = $client
        ->withCookies([
            function(Cookie $cookie){
                $cookie
                    ->name('session')
                    ->value('395qh09hr012yht');
            },
            function(Cookie $cookie){
                $cookie
                    ->name('csrf_token')
                    ->value('b71h4o3dk3ug19');        
            },
            function(Cookie $cookie){
                $cookie
                    ->name('user')
                    ->value('291de04a-249b-4c23-bc3e-aca89b6f75f7');   
            },
        ])
        ->get('/profile-data');
```

### Create Cookie

If you need to create `Cookie` instances, then this can be done via the `makeCookie()` method.

```php
// Create Cookies
$sessionCookie = $client->makeCookie();
$sessionCookie
    ->name('session')
    ->value('395qh09hr012yht');

$csrfTokenCookie = $client->makeCookie();
$csrfTokenCookie
    ->name('csrf_token')
    ->value('b71h4o3dk3ug19');
// ...etc

// ...Later 
$response = $client
        ->withCookies([
            $sessionCookie,
            $csrfTokenCookie,
            $userCookie
        ])
        ->get('/profile-data');
```

::: tip
`withCookie()` method also accepts a `Cookie` instance directly.

```php
$response = $client  
        ->withCookie($sessionCookie)
        ->get('/profile-data');
```
:::

## Remove Cookie

To remove an already added cookie, use the `withoutCookie()` method.
It accepts a cookie name as argument.

```php
$builder = $client  
        ->withoutCookie('csrf_token');
```
