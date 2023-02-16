---
description: Actions
sidebarDepth: 0
---

# Actions

The `Actions` component is used to either abort the current request, because a precondition has failed, or to change the state of the requested resource.
Usually, such logic is invoked by the [preconditions](preconditions.md).

::: tip Recommendation
The default provided `Actions` will satisfy the bare minimum requirements of RFC 9110.
However, they will most likely not satisfy your every need, for every type of resource that is evaluated.
You are therefore **strongly encouraged** to extend, overwrite or create your own [custom `Actions`](#custom-actions), when needed.  
:::

[[TOC]]

## Default Actions

Unless otherwise specified, the `DefaultActions` component is used by the evaluator. In this section, each method of the actions component is briefly described.

_Please see the source code of `\Aedart\ETags\Preconditions\Actions\DefaultActions` for additional details._

### Abort State Change Already Succeeded

The `abortStateChangeAlreadySucceeded()` is responsible for causing the application to return a [2xx response](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#successful_responses) response.
The method throws an `HttpException` with Http status code [204 No Content](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/204).

### Abort Precondition Failed

The `abortPreconditionFailed()` is responsible for causing the application to return a [412 Precondition Failed](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/412) response.
The method throws an an `PreconditionFailedHttpException` (_custom `HttpException`_).

### Abort Not Modified

The `abortNotModified()` is responsible for causing the application to return a [304 Not Modified](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/304) response.
Method throws an `HttpException` to achieve this.

### Abort Bad Request

The `abortBadRequest()` is responsible for causing the application to return a [400 Bad Request](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/400) response.
`BadRequestHttpException` is thrown with a custom `$reason` string, if provided by preconditions. 

### Abort Range Not Satisfiable

The `abortRangeNotSatisfiable()` is responsible for causing the application to return a [416 Range Not Satisfiable](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/416) response.
A `RangeNotSatisfiable` exception is thrown, which also contains information about requested `Range`, the total size of the resource, and a possible `$reason` why the request was aborted.

### Process Range

The `processRange()` method is responsible for changing the state of the provided resource, such that the application is able to respond with a [206 Partial Content](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/206) response.
This method is given a collection of ranges that were requested.
Furthermore, the method _SHOULD NOT_ abort the current request, but is allowed to do so if needed.

### Ignore Range

`ignoreRange()` is responsible for changing the state of the provided resource, such that application ignores evt. `Range` header.
The method _SHOULD NOT_ abort the current request, but is allowed to do so if needed.

## Custom Actions

### How to create

The easiest way to create your own custom actions, is by extending `DefaultActions`.
Overwrite the desired methods with the logic that you need. Consider the following example: 

```php
use Aedart\ETags\Preconditions\Actions\DefaultActions;

class MyCustomActions extends DefaultActions
{
    public function abortStateChangeAlreadySucceeded(
        ResourceContext $resource
    ): never
    {    
        // Abort request with a custom response (throws HttpException).
        abort(response()->json([
            'data' => $resource->data()->toArray()
        ], 200));
    }
}
```

::: warning Caution
When overwriting the "abort" methods, both the preconditions and the evaluator expect those methods to throw an appropriate exception and stop further request processing.
If this is not respected, you are very likely to experience undesired behavior.
:::

### Use custom actions

To use custom actions, set the `$actions` argument in the evaluator's `make()` method, or use the `setActions()` method.

```php
// When creating a new instance...
$evaluator = Evaluator::make(
    reqeust: $request,
    actions: new MyCustomActions(),
);

// Or, when after instance has been instantiated
$evaluator->setActions(new MyCustomActions());
```