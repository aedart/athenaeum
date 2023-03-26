---
description: Athenaeum Release Notes
sidebarDepth: 0
---

# Release Notes

[[toc]]

## Support Policy

Athenaeum attempts to follow a release cycle that matches closely to that of [Laravel](https://laravel.com/docs/10.x/releases).
However, due to limited amount of project maintainers, no guarantees can be provided. 

| Version | PHP         | Laravel | Release              | Security Fixes Until |
|---------|-------------|---------|----------------------|----------------------|
| `8.x`   | `8.2 - ?`   | `v11.x` | _~1st Quarter 2024_  | _TBD_                |
| `7.x`*  | `8.1 - 8.2` | `v10.x` | February 16th, 2023  | February 2024        |
| `6.x`   | `8.0 - 8.1` | `v9.x`  | April 5th, 2022      | February 2023        |
| `5.x`   | `7.4`       | `v8.x`  | October 4th, 2020    | _N/A_                |
| `< 5.x` | _-_         | _-_     | _See `CHANGELOG.md`_ | _N/A_                |

_*: current supported version._

_TBD: "To be decided"._

## `v7.x` Highlights

These are the highlights of the latest major version of Athenaeum.

### PHP `v8.1` and Laravel `v10.x`

PHP version `v8.1` is now the minimum required version for Athenaeum.
[Laravel `v10.x`](https://laravel.com/docs/10.x/releases) packages are now used.

### Http Conditional Requests

The [ETags package](./etags/README.md) has been upgraded to offer support for [RFC 9110's conditional requests](https://httpwg.org/specs/rfc9110.html#conditional.requests).
The following preconditions are supported by default:

* [If-Match](https://httpwg.org/specs/rfc9110.html#field.if-match)
* [If-Unmodified-Since](https://httpwg.org/specs/rfc9110.html#field.if-unmodified-since)
* [If-None-Match](https://httpwg.org/specs/rfc9110.html#field.if-none-match)
* [If-Modified-Since](https://httpwg.org/specs/rfc9110.html#field.if-modified-since)
* [If-Range](https://httpwg.org/specs/rfc9110.html#field.if-range)

See [documentation](./etags/evaluator/README.md) for details.

### `DownloadStream` Response Helper

As a part of the [ETags package](./etags/evaluator/download-stream.md), a `DownloadStream` response helper is now available.
It is able to create streamed response for `Range` requests.

```php
use Illuminate\Support\Facades\Route;
use Aedart\ETags\Preconditions\Responses\DownloadStream;

Route::get('/downloads/{file}', function (DownloadFileRequest $request) {

    return DownloadStream::for($request->resource)
        ->setName($request->route('file'));
});
```

### API Requests

The Http Api package has been upgraded with a few [Request abstractions](./http/api/requests/README.md).
These can speed up development of API endpoints. 

**Example Request**

```php
use Aedart\Http\Api\Requests\Resources\ShowSingleResourceRequest;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ShowUser extends ShowSingleResourceRequest
{
    public function findRecordOrFail(): Model
    {
        return User::findOrFail($this->route('id'));
    }

    public function mustEvaluatePreconditions(): bool
    {
        return true;
    }
}
```

**Example Action**

```php
Route::get('/users/{id}', function (ShowUser $request) {
    return UserResource::make($request->record)
        ->withCache();
})->name('users.show');
```

### Api Resource Http Caching

Additionally, Api Resources now have the ability to set [Caching headers](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cache-Control), [ETag](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/ETag), and [Last-Modified date](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Last-Modified), via a single method:

```php
Route::get('/addresses/{id}', function ($id) {
    return new AddressResource(Address::findOrFail($id))
        ->withCache();
});
```

See [documentation](./http/api/resources/caching.md) for details.

### Custom Queries for Search and Sorting Filters

The `SearchFilter` and `SearchProcessor` now support custom search callbacks.

```php
use Aedart\Filters\Processors\SearchProcessor;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;

$processor = SearchProcessor::make()
        ->columns(function(Builder|EloquentBuilder $query, string $search) {
            return $query
                ->orWhere($column, 'like', "{$search}%");
        });
```

The same applies for the `SortFilter` and `SortingProcessor`.

```php
use Aedart\Filters\Processors\SortingProcessor;

$processor = SortingProcessor::make()
        ->sortable([ 'email', 'name'])
        ->withSortingCallback('email', function($query, $column, $direction) {
            return $query->orderBy("users.{$column}", $direction);
        });
```

### Remove Response Payload Middleware

A new middleware has been added for the Http Api package, which is able to remove a response's body, when a custom query parameter is available.
See [middleware documentation](./http/api/middleware/remove-response-payload.md) for details.

### Attach File Stream for Http Client

The Http Client now supports uploading a file stream.

```php
use Aedart\Streams\FileStream;

$response = $client  
        ->attachStream('2023_annual.pdf', FileStream::open('/reports/2023_annual.pdf', 'r'))
        ->post('/reports/annual');
```

### Improved Status object

The `Status` object that is provided for [response expectations](./http/clients/methods/expectations.md) has been improved.
It now contains several helper methods for determining if it matches a desired Http status code.

```php
use Aedart\Contracts\Http\Clients\Responses\Status;
use Teapot\StatusCode\All as StatusCode;

$client
    ->expect(function(Status $status){
        if ($status->isBadGateway()) {
            // ...
        }
            
        if ($status->is(StatusCode::UNPROCESSABLE_ENTITY)) {
            // ...
        }
        
        if ($status->satisfies([ StatusCode::CREATED, StatusCode::NO_CONTENT ])) {
            // ...
        }
        
        // ... etc
    });
```

### Stream `hash()` accept hashing options

Streams now accept and apply [hashing options](https://www.php.net/manual/en/function.hash-init) in `hash()` method. This was previously also supported, but required PHP `v8.1`.
PHP version check is no longer performed internally. See [documentation](./streams/usage/hash.md) for more details.

### Stream `sync()` is now supported

File streams can now have their content synchronised to file, via the `sync()` method.
See [example](./streams/usage/sync.md).

### `to()` memory unit method

The [Memory](./utils/memory.md) utility now offers a `to()` method, which allows specifying a string unit to convert the memory unit into.

```php
echo Memory::unit(6_270_000_000) // bytes
    ->to('gigabyte', 2); // 6.27
```

## Changelog

Make sure to read the [changelog](https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md) for additional information about the latest release, new features, changes and bug fixes. 
