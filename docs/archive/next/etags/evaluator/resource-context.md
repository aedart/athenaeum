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
* **`ETag|null $etag = null`: (_optional_) Etag of the requested resource.**
* **`DateTimeInterface|null $lastModifiedDate = null`: (_optional_) Resource's last modified date.**
* `int $size = 0`: (_optional_) Size of resource. (_Applicable only if your request supports `If-Range` and `Range` requests._)
* `callable|null $determineStateChangeSuccess = null`: (_optional_) Callback that determines if a state change has already succeeded on the resource.
* `string $rangeUnit = 'bytes'`: (_optional_) Allowed or supported [range unit](https://httpwg.org/specs/rfc9110.html#range.units), e.g. `"bytes"`.
* `int $maxRangeSets = 5`: (_optional_) Maximum allowed [range sets](https://httpwg.org/specs/rfc9110.html#rule.ranges-specifier).

Most of the arguments are optional. You do not have to satisfy all of them, especially not when your requested resource is not intended to support them.
As an example, imagine that an existing record (_e.g. an Eloquent Model instance_) is requested.
If your model supports etags, and has a last modified date, then you can create a new `GenericResource` instance in the following way:

```php
use Aedart\ETags\Preconditions\Resources\GenericResource;

$resource new GenericResource(
    data: $model,
    etag: $model->getStrongEtag(),
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
    etag: $model->getStrongEtag(),
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

If your resource is a picture, document or other kind of file that is intended to support [`Range`](https://httpwg.org/specs/rfc9110.html#field.range) requests,
and or [`If-Range`](https://httpwg.org/specs/rfc9110.html#field.if-range) precondition, then you must specify the `$size` of the resource.

### Default Behaviour

The `GenericResource` assumes that the resource in question does NOT support `Range` and `If-Range`.
It defaults to `$size = 0`, in the constructor. This results in `Range` and `If-Reange` Http headers to be entirely ignored.
Your resulting response should therefore include the full file content. 

### Size and Range Response

You can specify a file's size using the `$size` constructor argument.
When you do so, the `ResourceContext` is automatically marked to support `Range` and `If-Range` requests.  

```php{5}
$resource new GenericResource(
    data: $file,
    etag: $file->getStrongEtag(),
    lastModifiedDate: $file->updated_at,
    size: $file->getFileSize()
);
```

The `Evaluator`'s preconditions will automatically deal with validation of requested range-sets.
You will, however, have to create an appropriate [206 Partial Content](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/206)
in your controller or route action, when the "range" state has been set on the resource.
Use the `mustProcessRange()`, `mustIgnoreRange()` and `ranges()` to deal with such.

#### Example Request

```php

```

#### Example Action

## Arbitrary Data