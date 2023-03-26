---
description: Http Api Validated Requests - Show Single Resource Request
sidebarDepth: 0
---

# Show Resource

`ShowSingleResourceRequest` abstraction is intended for when a single resource must be shown.

[[TOC]]

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

## Authorisation

Authorisation checks is performed by the `authorizeFoundRecord()` method (_see source code for details_).
The request will check against a `show` ability.
From the above shown examples, a `users.show` ability is checked.

## Request Preconditions

To enable evaluation of requested preconditions, the `mustEvaluatePreconditions()` method must return `true`.

```php
// ...inside your request...

public function mustEvaluatePreconditions(): bool
{
    return true;
}
```

The request abstraction will take care of the rest.
The found record (_your Eloquent Model_) will be wrapped into a [Resource Content](../../../etags/evaluator/resource-context.md), and requested preconditions are automatically evaluated.

### ETag and Last-Modified Date

When a record is found, and it [supports etags](../../../etags/etags/eloquent.md), a strong etag is automatically obtained and passed further to the `ResourceContent`.
The same is true for a last modified date (_typically your model's `updated_at` property_).
To configure this behaviour, overwrite `getRecordEtag()` and/or `getRecordLastModifiedDate()`.

```php
use Aedart\Contracts\ETags\ETag;
use Aedart\Http\Api\Requests\Resources\ShowSingleResourceRequest;
use DateTimeInterface;

class ShowUser extends ShowSingleResourceRequest
{
    // ...previous not shown...

    public function getRecordEtag(): ETag|null
    {
        // The found record...
        $record = $this->record;
        
        // Return valid etag for record - not shown here...
    }

    public function getRecordLastModifiedDate(): DateTimeInterface|null
    {
        // The found record...
        $record = $this->record;
        
        // Return valid last modified date for record - not shown here...
    }
}
```

### Resource Context

By default, a [Generic Resource](../../../etags/evaluator/resource-context.md) instance is used for wrapping the found record into a resource context.
The `wrapResourceContext()` method is responsible for this.

```php
use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use DateTimeInterface;

// ...inside your request...

public function wrapResourceContext(
    mixed $record,
    ETag|null $etag = null,
    DateTimeInterface|null $lastModifiedDate = null
): ResourceContext
{
    // Return a Resource Context for the found record - not shown here...
}
```

### Actions

To use [custom actions](../../../etags/evaluator/actions.md), overwrite the `preconditionActions()`.

```php
use Aedart\Contracts\ETags\Preconditions\Actions;
use App\Http\Users\Preconditions\UserActions;

// ...inside your request...

public function preconditionActions(): Actions|null
{
    return new UserActions();
}
```

### Preconditions

The default [supported preconditions](../../../etags/evaluator/preconditions.md#supported-preconditions) are used, when evaluation is enabled for your request.
To add additional preconditions (_[extensions](../../../etags/evaluator/extensions/README.md)_), use the `additionalPreconditions()` method. 

```php
use App\Http\Preconditions\IfAuthor;

// ...inside your request...

public function additionalPreconditions(): array
{
    return [
        IfAuthor::class
    ];
}
```

### Evaluator

Lastly, if your request needs additional configuration of the `Evaluator` instance, then you can overwrite the `makePreconditionsEvaluator()` method.

```php
use Aedart\Contracts\ETags\Preconditions\Evaluator;

// ...inside your request...

public function makePreconditionsEvaluator(): Evaluator
{
    $evaluator = parent::makePreconditionsEvaluator();

    // ...configure evaluator... not shown here...
   
    return $evaluator;
}
```

### Onward

See the source code of `\Aedart\Http\Api\Requests\Concerns\HttpConditionals` for additional details.