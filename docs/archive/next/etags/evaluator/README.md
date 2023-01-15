---
description: How to work with Http Conditional Requests Evaluator
sidebarDepth: 0
---

# Introduction

[[TOC]]

## The Basics

The design philosophy behind the request preconditions `Evaluator` is to evaluate an incoming [conditional request (precondition)](https://httpwg.org/specs/rfc9110.html#preconditions), e.g. `If-Match`, against the requested [resource](./resource-context.md).   

When a precondition is evaluated, either of the following will happen:

* When it passes (`true`):
  * Evaluator continues to evaluate another precondition (_if requested_).
  * Or it returns a changed [resource](./resource-context.md) (_e.g. a state change or perhaps entirely modified resource_).
* When it fails (`false`):
  * The request is aborted by throwing an appropriate `HttpException`, via an [`Actions` component](./actions.md).
  * The [resource](./resource-context.md) changed and returned.

All preconditions are evaluated in accordance with [RFC9110's order of precedence](https://httpwg.org/specs/rfc9110.html#precedence).
See [supported preconditions](./preconditions.md#supported-preconditions) for additional information.

## How to Evaluate

Http Conditional Requests are always specific to the requested resource and the [Http Method](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods).
It is therefore recommended that you evaluate the requested resource inside your [Form Request](https://laravel.com/docs/9.x/validation#form-request-validation).
When doing so, you should be able to keep your [controller](https://laravel.com/docs/9.x/controllers#main-content) or [route action](https://laravel.com/docs/9.x/routing#basic-routing) clean from this kind of logic.
Consider the following form request:

### Request

```php
use Aedart\Contracts\ETags\HasEtag;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Preconditions\Evaluator;
use Aedart\ETags\Preconditions\Resources\GenericResource;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class ShowUserRequest extends FormRequest
{
    public ResourceContext $resource;

    public function withValidator(Validator $validator): void
    {
        // Acc. to RFC9110, evaluation of preconditions SHOULD be performed
        // after regular validation...
        $validator->after([$this, 'evaluatePreconditions']);
    }

    public function evaluatePreconditions(Validator $validator): void
    {
        // 1) Find requested resource or fail.
        $model = $this->findOrFailModel();

        // 2) Wrap it inside a Resource Context
        $resource = $this->makeResourceContext($model);

        // 3) Evaluate request's preconditions against resource...
        $this->resource = Evaluator::make($this)
            ->evaluate($resource);
    }

    protected function makeResourceContext(Model & HasEtag $model): ResourceContext
    {
        return new GenericResource(
            data: $model,
            etag: $model->getStrongEtag(),
            lastModifiedDate: $model->updated_at
        );
    }

    protected function findOrFailModel(): Model & HasEtag
    {
        // ...not shown ...
    }
}
```

### Route or Controller Action

In your controller or route's action, you can then return the requested resource with [cache headers](./../macros.md#withcache). 

```php
use Illuminate\Support\Facades\Route;

Route::get('/user/{id}', function (ShowUserRequest $request) {
    $resource = $request->resource;
    $payload = $resource
        ->data()
        ->toArray();

    return response()
        ->json($payload)
        ->withCache(
            etag: $resource->etag(),
            lastModified: $resource->lastModifiedDate(),
            private: true
        );
})->name('users.show');
```

### Responses

Whenever a request without preconditions is received by your application, for instance:

```txt
GET /users/42 HTTP/1.1
```

Then your application will return the requested resource, along with a few cache headers.

```txt
HTTP/1.1 200 OK
Cache-Control: private
Etag: "a81283f2670a78cd4c5a2e56cb0cd4ef5e357eb1"
Last-Modified: Sun, 15 Jan 2023 16:13:23 GMT
Content-Type: application/json

{"id":42,"name":"John Doe","age":31,"updated_at":"2023-01-15T16:13:23.000000Z"}
```

However, when a request contains a preconditions, e.g. [`If-None-Match`](https://httpwg.org/specs/rfc9110.html#field.if-none-match), then it is processed.
In the case of the following, the [`If-None-Match`](https://httpwg.org/specs/rfc9110.html#field.if-none-match) precondition
fails because the etag value matches the resource's etag  and therefore
a [304 Not Modified](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/304) response is returned. 

```txt
GET /users/42 HTTP/1.1
If-None-Match: "a81283f2670a78cd4c5a2e56cb0cd4ef5e357eb1"
```

```txt
HTTP/1.1 304 Not Modified
```

Thus, the controller or route action is never executed. Instead, an exception is thrown and the application converts it into an appropriate response.

You are free to implement the evaluation logic how you see fit, in your application.
The above shown examples are only meant to demonstrate the general process. The rest is up to you.

## The Evaluator

The `Evaluator::make()` method accepts 3 arguments:

* `Request $request`: the incoming request.
* `string[]|Precondition[] $preconditions = []`: _(optional)_ list of [preconditions](./preconditions.md) to evaluate.
  * _Defaults to RFC 9110 + extension preconditions, when none are given._
* `Actions|null $actions = null`: _(optional)_ "abort" or "state change" [actions](./actions.md) instance.
  * _Defaults to a default actions instance, when none is given._

```php
use Aedart\ETags\Preconditions\Evaluator;

// Create evaluator instance (with defaults)
$evaluator = Evaluator::make($request);

// ...Or when you have custom preconditions / actions
$evaluator = Evaluator::make(
    reqeust: $request,
    preconditions: $myPreconditionsArray,
    actions: $myActions
);
```

Once you have instantiated an evaluator instance, use the `evaluate()` method to evaluate request's preconditions against the requested resource.
The method accepts a [`ResourceContext`](./resource-context.md) instance and will either return the resource (_possible changed_), or throw a `HttpException`. 

```php
$evaluator->evaluate($resource);
```

If an exception is thrown, then your Laravel application's exception handler will process it and create a response.
See [Laravel's documentation](https://laravel.com/docs/9.x/errors#the-exception-handler) for additional information.