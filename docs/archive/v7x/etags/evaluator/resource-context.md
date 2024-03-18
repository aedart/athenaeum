---
description: Resource Context
sidebarDepth: 0
---

# Resource Context

A `ResourceContext` represents a requested resource. It acts as a wrapper for the requested record or file.
It may also contain state information about the resource itself.

[[TOC]]

## How to create

This packages comes with a `GenericResource`, which is a default implementation of the `ResourceContext` interface. 
Its constructor method accepts the following arguments:

* **`mixed $data`: The requested resource, e.g. a record, Eloquent Model instance, a file... etc.**
* **`ETag|callable|null $etag = null`: (_optional_) Etag of the requested resource or callback to resolve etag.**
* **`DateTimeInterface|null $lastModifiedDate = null`: (_optional_) Resource's last modified date.**
* `int $size = 0`: (_optional_) Size of resource. (_Applicable only if your request supports `If-Range` and `Range` requests._)
* `callable|null $determineStateChangeSuccess = null`: (_optional_) Callback that determines if a state change has already succeeded on the resource.
* `string $rangeUnit = 'bytes'`: (_optional_) _See [Accept-Ranges](./download-stream.md#accept-ranges)_.
* `int $maxRangeSets = 5`: (_optional_) Maximum allowed [range sets](https://httpwg.org/specs/rfc9110.html#rule.ranges-specifier).

Most of the arguments are optional. You do not have to satisfy all of them. This is especially true when your requested resource is not intended to support `If-Range` and `Range` preconditions.

To demonstrate an example, imagine that an existing record (_e.g. an Eloquent Model instance_) is requested.
If your model supports etags, and has a last modified date, then you can create a new `GenericResource` instance in the following way:

```php
use Aedart\ETags\Preconditions\Resources\GenericResource;

$resource new GenericResource(
    data: $model,
    etag: $model->getStrongEtag(),
    lastModifiedDate: $model->updated_at
);
```

## Callable ETag Argument

_**Available since** `v7.9.x`_

The `$etag` argument can be specified as callback that resolves an actual `ETag` instance. 
Doing so can increase performance of a request, when no preconditions are requested.
The etag is only resolved when needed and not upfront.

```php{3}
$resource new GenericResource(
    data: $model,
    etag: fn () => $model->getStrongEtag(),
    lastModifiedDate: $model->updated_at
);
```

## Determine State Change Success

Whenever [`If-Match`](rfc9110/if-match.md) or [`If-Unmodified-Since`](rfc9110/if-unmodified-since.md) preconditions are requested and evaluated as `false`,  
a [412 Precondition Failed](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/412) response will be returned, _**unless** it can be determined that the
state-changing request has already succeeded._ (See [RFC9110 for details](https://httpwg.org/specs/rfc9110.html#field.if-match)).

Imagine that a `DELETE` request is received for a record with a `If-Unmodified-Since` precondition.
If the precondition is evaluated to `true`, then the request can proceed and delete the record.
Otherwise, the application must determine if a "state-change" has already occurred (_if the record has already been deleted_). 

When such a situation arises, the `hasStateChangeAlreadySucceeded()` method will be invoked, on the `ResourceContext` instance.
Depending on the return value, the following will happen:

* When state-change is `false`
  * The evaluator ensures a "412 Precondition Failed" response, via its assigned [`Actions`](actions.md#abort-precondition-failed).
* When state-change is `true`
  * The request is aborted via evaluator's assigned [`Actions`](actions.md#abort-state-change-already-succeeded).

### Default Behaviour

The `GenericResource` will return `false` as default, when no callback is given for the `$determineStateChangeSuccess` constructor argument.
This will result in a [412 Precondition Failed](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/412) response, when `If-Match` or `If-Unmodified-Since`
precondition fail.

### Custom Behaviour

To change the default behaviour, specify a callback for the `$determineStateChangeSuccess` constructor argument.
When invoked, the callback will receive the current Http Request, and the resource context as arguments. 

```php
use Aedart\ETags\Preconditions\Resources\GenericResource;

$resource new GenericResource(
    data: $model,
    etag: fn () => $model->getStrongEtag(),
    lastModifiedDate: $model->updated_at,
    determineStateChangeSuccess: function($request, $resource) {
        $model = $resource->data();
    
        if ($request->method() === 'DELETE' && !is_null($model->deleted_at)) {
            return true;
        }
        
        // ...other state-change determination logic not shown...
        
        return false;
    } 
);
```

## Files and Range Support

If your resource is a picture, document or other kind of file that is intended to support [`If-Range`](https://httpwg.org/specs/rfc9110.html#field.if-range)
and [`Range`](https://httpwg.org/specs/rfc9110.html#field.range) requests, then you must specify the `$size` of the resource.
The `$size` must always be specified in bytes.

### Default Behaviour

The `GenericResource` assumes that the resource in question does NOT support `Range` and `If-Range`.
It defaults to `$size = 0`, in the constructor. This results in `Range` and `If-Range` Http headers to be entirely ignored.
Your resulting response should therefore include the full file content. 

### Size and Range Response

You can specify a file's size (_in bytes_) using the `$size` constructor argument.
When you do so, the `ResourceContext` is automatically marked to support `Range` and `If-Range` requests.  

```php{5}
$resource new GenericResource(
    data: $file,
    etag: $file->getStrongEtag(),
    lastModifiedDate: $file->updated_at,
    size: $file->getFileSize()
);
```

The `Evaluator`'s preconditions will automatically deal with [validation of requested range-sets](range-validator.md).
You will, however, have to create an appropriate [206 Partial Content](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/206)
in your controller or route action, when the "range" state has been set on the resource.

#### Example Request

```php

use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Facades\Generator;
use Aedart\ETags\Preconditions\Evaluator;
use Aedart\ETags\Preconditions\Resources\GenericResource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\File;
use Illuminate\Support\Carbon;

class DownloadFileRequest extends FormRequest
{
    public ResourceContext $resource;

    protected function prepareForValidation()
    {
        // 1) Find requested file or fail.
        $file = $this->findFileOrFail();

        // 2) Wrap it inside a Resource Context
        $resource = $this->makeResourceContext($file);

        // 3) Evaluate request's preconditions against resource...
        $this->resource = Evaluator::make($this)
            ->evaluate($resource);
    }

    protected function makeResourceContext(File $file): ResourceContext
    {
        // (optional) generate custom etag for file 
        $etag = Generator::makeRaw(
            hash_file('xxh128', $file->getRealPath())
        );

        // Returns new resource for given file...
        return GenericResource::forFile(
            file: $file,
            etag: $etag // Defaults to a "checksum" etag, when not specified!
        );
    }

    protected function findFileOrFail(): File
    {
        // ... not shown here...
    }
}
```

#### Example Action

```php
use Illuminate\Support\Facades\Route;
use Aedart\ETags\Preconditions\Responses\DownloadStream;

Route::get('/files/{name}', function (DownloadFileRequest $request) {

    return DownloadStream::for($request->resource)
        ->setName($request->route('name'));
});
```

_See [Download Stream](./download-stream.md) response helper, for additional information._

#### Example Response

Based on the above shown request and action, if a client makes a request with `If-Range` and `Range` preconditions, then a [206 Partial Content](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/206) response is returned, if the preconditions match.

**Request (_with If-Range and Range_)**

```
GET /files/contacts.txt HTTP/1.1
If-Range: "a89ca792333a300d726d40ecbbb9b043"
Range: bytes=0-99
```

**Response (_206 Partial Content_)**

```
HTTP/1.1 206 Partial Content
Date: Fri, 03 Feb 2023 10:05:24 GMT
Last-Modified: Tue, 15 Jan 2023 08:58:08 GMT
Content-Range: bytes 0-99/2087
Content-Length: 100
Content-Type: plain/text
Content-Disposition: attachment; filename=contacts.txt

(100 bytes of partial text file... not shown here)
```

## Arbitrary Data

The `ResourceContext` also has the ability to store and retrieve arbitrary data.
This can be useful for adding additional meta information for a resource, or perhaps for dealing with complex state-changing logic.
Regardless of reason, you can leverage this mechanism when you need it.

Most commonly, you would set key-value pairs inside your resource, by accessing the resource in your custom [actions](actions.md).

### Examples

```php
// Set key-value
$resource->set('foo', 'bar');

// Obtain value for key... default to a value if not available
$value = $resource->get('foo', 'zap');

// Determine if key exists
if ($resource->has('foo')) {
    // ...
}

// Forget (remove) a key-value pair
$resource->delete('foo');

// Get all key-value pairs
$data = $resource->all();

// Determine if resource has any key-value pairs set
if ($resource->isEmpty()) {
    // ...
}
```