---
description: Http Api Resource Cache Headers
sidebarDepth: 0
---

## Http Caching

Http [Caching headers](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cache-Control), [ETag](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/ETag), and [Last-Modified date](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Last-Modified) can be applied directly on each `ApiResource`, by means of a few helper methods.

[[TOC]]

## With Cache 

When you wish to apply caching headers to the response, use the `withCache()`.
It will automatically apply a set of default caching headers, including an ETag and Last-Modified date of the underlying resource (_if possible_).

```php
Route::get('/addresses/{id}', function ($id) {
    return new AddressResource(Address::findOrFail($id))
        ->withCache();
});
```

The resulting Http response will look similar to the following:

```
HTTP/1.0 200 OK
Cache-Control: no-cache, private
Content-Type:  application/json
Date:          Tue, 07 Feb 2023 09:04:36 GMT
Etag:          "2716128cd82490cd01dddbeb2cf84030"
Last-Modified: Tue, 07 Feb 2023 08:55:36 GMT

# ...body not shown...
```

### Customise Headers

To customise the default caching header, you can set them directly before creating a response, via the `withCache()`:

```php
Route::get('/addresses/{id}', function ($id) {
    return new AddressResource(Address::findOrFail($id))
        ->withCache([
            'no_cache' => false
        ]);
});
```

Alternatively, you may also overwrite the `defaultCacheHeaders()` method inside your Api Resource instance.

```php
// ...inside your Api Resource...

public function defaultCacheHeaders(): array
{
    return [
        'etag' => $this->getEtag(),
        'last_modified' => $this->getLastModifiedDate(),
        'private' => true,

        'max_age' => 3600,
        's_maxage' => null,
        'must_revalidate' => true,
        'no_cache' => false,
        'no_store' => false,
        'no_transform' => false,
        'public' => false,
        'proxy_revalidate' => false,
        'immutable' => false,
    ];
}
```

## ETag

When invoking the `withCache()` method, the Api Resource attempts to resolve a default ETag for its underlying resource.
See [Eloquent ETag](../../../etags/etags/eloquent.md) for details.

If you wish to specify a custom ETag, then use the `withEtag()` method. 
The method accepts either a string value or [`ETag` instance](../../../etags/etags/README.md).

```php
Route::get('/addresses/{id}', function ($id) {
    return new AddressResource(Address::findOrFail($id))
        ->withEtag('"a89ca792333a300d726d40ecbbb9b043"');
});
```

To remove an ETag from the response, you can use the `withoutEtag()`.

```php
Route::get('/addresses/{id}', function ($id) {
    return new AddressResource(Address::findOrFail($id))
        ->withCache()
        ->withoutEtag();
});
```

**Note**: _Invoking `withoutEtag()` has no effect when no caching headers or ETag was set!_

## Last Modified Date

A similar behaviour is true for the Last Modified date, as for [ETag](#etag); a date is automatically attempted resolved from the underlying resource, when `withCache()` is invoked.

To specify a custom date, use `withLastModifiedDate()`.
The method accepts a string date or `DateTimeInterface`.

```php
Route::get('/addresses/{id}', function ($id) {
    return new AddressResource(Address::findOrFail($id))
        ->withLastModifiedDate(now());
});
```

To remove a Last Modified Date from the response, use `withoutLastModifiedDate()`.

```php
Route::get('/addresses/{id}', function ($id) {
    return new AddressResource(Address::findOrFail($id))
        ->withCache()
        ->withoutLastModifiedDate();
});
```

**Note**: _Invoking `withoutLastModifiedDate()` has no effect when no caching headers or Last Modified date was set!_