---
description: Http Api Validated Requests
sidebarDepth: 0
---

# Introduction

This package also offers a few opinionated [Form Request](https://laravel.com/docs/13.x/validation#form-request-validation) abstractions, intended to be used for APIs.

[[TOC]]

## Prerequisites

The request abstractions are ONLY available when you are working in a full Laravel application.
The abstractions inherit from the `FormRequest` class, which is only available in Laravel's Foundation namespace.

## Validated Api Request

At the top-most abstraction level, you will find the `ValidatedApiRequest`.
It offers but a few additional features, such as an `afterValidation()` method that can be overwritten to perform additional business logic validation, after your request's regular validation has completed.

```php
use Aedart\Http\Api\Requests\ValidatedApiRequest;
use Illuminate\Contracts\Validation\Validator;

class ShowProfile extends ValidatedApiRequest
{
    public function rules(): array
    {
        return [
            // ...rules not shown here...
        ];
    }
    
    public function afterValidation(Validator $validator): void
    {
        // Use this method to perform additional validation.
    }
}
```

The `$validator` instance that is provided for the `afterValidation()` method contains all valid data.
You can access the data and use it, if needed.
Examples of what kind of additional validation you might perform, could be:

* Complex cross-field validation that [regular validation rules](https://laravel.com/docs/13.x/validation#available-validation-rules) might not be able to satisfy.
* Query additional resources and ensure they exist, match or otherwise fit with what is requested.
* Perform special domain specific conditions check (_whatever that might be for your application_).
* _Prepare data to be processed by your route or controller action._

The last example might not be that self-evident. However, sometimes when preparing data for processing, additional validation might be required. 
This might be true, when certain kinds of validation logic only can be performed during data preparation.

## Authorisation

To perform authorisation checks, you can leverage the `authorize()` method (_available via Laravel's `FormRequest`_).

```php
public function authorize()
{
    $comment = Comment::find($this->route('comment'));
 
    return $comment && $this->allows('show', $comment);
}
```

The `authorize()` method is invoked before your regular validation is performed.
But, sometimes it might not be possible or feasible to perform authorisation checks before data validation.
In such situations, you can leverage the `authorizeAfterValidation()` method.

```php
public function authorizeAfterValidation(): bool
{
    // Obtain your data, model instance... or whatever
    // might be required to perform authorisation...
    $record = $this->record;
    
    return $this->allows('update', $record);
}
```

The `authorizeAfterValidation()` method is automatically invoked after the `afterValidation()` method has executed.

## Http Conditional Requests

The `ValidatedApiRequest` also offers support for dealing with [Http Conditional Requests](https://developer.mozilla.org/en-US/docs/Web/HTTP/Conditional_requests).
It is able to evaluate request preconditions, via the [`Evaluator` component](../../../etags/evaluator/README.md).
To enable evaluation of preconditions, invoke the `evaluateRequestPreconditions()` method.

```php
use Aedart\Contracts\ETags\HasEtag;
use Aedart\Http\Api\Requests\ValidatedApiRequest;
use Illuminate\Database\Eloquent\Model;

class ShowProfile extends ValidatedApiRequest
{
    protected function prepareForValidation()
    {
        // 1) Find requested resource or fail.
        $model = $this->findOrFailModel();

        // 2) Evaluate request preconditions for "record"
        $resource = $this->evaluateRequestPreconditions(
            record: $model,
            etag: fn () => $model->getStrongEtag(),
            lastModifiedDate: $model->updated_at
        );
    }

    protected function findOrFailModel(): Model & HasEtag
    {
        // ...not shown ...
    }
}
```

Please review `\Aedart\Http\Api\Requests\Concerns\HttpConditionals` and the [ETags package documentation](../../../etags/README.md) for additional information.

## Onward

Throughout the remaining of this chapter, additional specialised API request abstractions are briefly highlighted.
Feel free to extend and use these abstractions, as you see fit.