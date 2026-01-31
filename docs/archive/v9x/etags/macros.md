---
title: Macros
description: Http Request & Response Macros
sidebarDepth: 0
---

# Request / Response Macros

Etags and precondition evaluator components depend on a few [Http Request & Response Macros](https://laravel.com/docs/12.x/responses#response-macros).
These are automatically installed by this package's service provider.
The following highlights the macros that are installed. 

[[TOC]]

## Request Macros

### `ifMatchEtags()`

The `ifMatchEtags()` returns a collection or `ETag` instances, from the [`If-Match` Http header](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/If-Match).

```php
$collection = $request->ifMatchEtags();

if ($collection->isNotEmpty()) {
    // ...remaining not shown ...
}
```

### `ifNoneMatchEtags()`

Returns a collection or `ETag` instances, from the [`If-None-Match` Http header](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/If-None-Match).

```php
$collection = $request->ifNoneMatchEtags();

if ($collection->isEmpty()) {
    // ...remaining not shown ...
}
```

### `ifModifiedSinceDate()`

Returns a [`DateTime`](https://www.php.net/manual/en/class.datetimeinterface) instance of the [`If-Modified-Since` Http header](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/If-Modified-Since), or `null` if not set.

```php
$datetime = $request->ifModifiedSinceDate();

if (!is_null($datetime)) {
    // ...remaining not shown ...
}
```

**Note**: _The method will return `null` if the HTTP Method is not `GET` or `HEAD`, or if the request contains an `If-None-Match` header. See [RFC-9110](https://httpwg.org/specs/rfc9110.html#field.if-modified-since) for additional information._

### `ifUnmodifiedSinceDate()`

Returns a [`DateTime`](https://www.php.net/manual/en/class.datetimeinterface) instance of the [`If-Unmodified-Since` Http header](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/If-Unmodified-Since), or `null` if not set.

```php
$datetime = $request->ifUnmodifiedSinceDate();

if ($datetime instanceof \DateTimeInterface) {
    // ...remaining not shown ...
}
```

**Note**: _The method will return `null` if the request contains an `If-Match` header. See [RFC-9110](https://httpwg.org/specs/rfc9110.html#field.if-unmodified-since) for additional information._

### `ifRangeEtagOrDate()`

The [`If-Range` Http header](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/If-Range) is slightly special. It can contain an [HTTP-Date](https://httpwg.org/specs/rfc9110.html#http.date) or an [ETag value](https://httpwg.org/specs/rfc9110.html#field.etag).
Therefore, the `ifRangeEtagOrDate()` method will return one of the following:

* [`DateTime`](https://www.php.net/manual/en/class.datetimeinterface) instance
* `ETag` instance
* `null` (_if the `If-Range` header was not set, or if request does not contain a `Range` header. See [RFC-9110](https://httpwg.org/specs/rfc9110.html#field.if-range) for additional information_).

```php
use Aedart\Contracts\ETags\ETag;

$value = $request->ifRangeEtagOrDate();

if ($value instanceof ETag) {
    // ... not shown ...
} elseif ($value instanceof \DateTimeInterface) {
    // ... not shown ...
} else {
    // "If-Range" was not requested, or "Range" header was not set...
}
```

## Response Macros

### `withEtag()`

The `withEtag()` method allows you to set the [`ETag` Http header](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/ETag), from an `ETag` instance.
**Note**: _This method is an adaptation of Symfony's [`setEtag()`](https://symfony.com/doc/current/components/http_foundation.html#managing-the-http-cache)._

```php
use Aedart\ETags\Facades\Generator;
use Illuminate\Http\Response;

$etag = Generator::makeStrong('my-content');

$response = (new Response())
    ->withEtag($etag);
```

### `withoutEtag()`

If you need to remove a response's `ETag` Http header, use the `withoutEtag()`.

```php
$response = (new Response())
    ->withEtag($etag);

// Later in your application - remove ETag
$response->withoutEtag();
```

### `withCache()`

The `withCache()` method is an adapted version of Symfony's [`setCache()`](https://symfony.com/doc/current/components/http_foundation.html#managing-the-http-cache), that allows an `ETag` instance to be specified, along with the rest of the cache headers.

```php
$etag = Generator::makeStrong('my-content');

$response = (new Response())
    ->withCache(
        etag: $etag,
        lastModified: now()->addHours(3)->addSeconds(43),
        private: true
    );
```