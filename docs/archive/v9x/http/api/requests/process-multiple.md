---
description: Http Api Validated Requests - Process Multiple Resources Requests
sidebarDepth: 0
---

# Process Multiple Resources

The `ProcessMultipleResourcesRequest` is intended for when bulk operations must be undertaken on multiple resources.
Based on a few configuration parameters, the request will automatically query the resources from the database, and perform authorisation thereof, before continuing to the route or controller action.

[[TOC]]

**Example Request**

```php
use Aedart\Http\Api\Requests\Resources\ProcessMultipleResourcesRequest;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;

class DeleteMultipleUsers extends ProcessMultipleResourcesRequest
{
    public function configureValuesToAccept(): void
    {
        // Accept string identifiers... 
        $this->acceptStringValues('email');
    }

    public function authorisationModel(): string|null
    {
        return User::class;
    }

    public function authorizeFoundRecords(Collection $records): bool
    {
        return $this->allows('bulk-destroy', [
            $this->authorisationModel(),
            $records
        ]);
    }
}
```

**Example Action**

```php
Route::delete('/games', function (DeleteMultipleUsers $request) {
    $users = $request->records;

    $emails = $users
        ->pluck('email')
        ->toArray();

    User::whereIn('email', $emails)
        ->delete();

    return response()->noContent();
})->name('users.bulk-destroy');
```

## Identifiers

The `configureValuesToAccept()` should be used to configure what kind of identifiers are expected to be present in the request's payload.
You can choose between string or integer values.

```php
// ...inside your request...

public function configureValuesToAccept(): void
{
    // Accept string values for "target" property.
    // 'email' is the unique table column to match string values against.
    $this->acceptStringValues('email');
    
    // Or... Accept integer values for "target" property.
    // 'id' is the unique table column to match integer values against.
    $this->acceptIntegerValues('id');
}
```

### The "targets" Key

By default, the request expects a payload to be formatted in the following way:

**Example (_string values_)**

```json
{
    "targets": [
        "john@example.org",
        "charlotte@example.org",
        "rick@example.org"
    ]
}
```

**Example (_integer values_)**

```json
{
    "targets": [
        42,
        64,
        77
    ]
}
```

A `targets` key is expected to contain a [distinct](https://laravel.com/docs/12.x/validation#rule-distinct) list of integers or string values.
These values act as identifiers for when querying records in the database. 
If the `targets` key name is not to your liking, then you can change this by overwriting the `ccc` property.

```php
use Aedart\Http\Api\Requests\Resources\ProcessMultipleResourcesRequest;

class DeleteMultipleUsers extends ProcessMultipleResourcesRequest
{
    /**
     * Name of property in received request payload that
     * holds identifiers.
     *
     * @var string
     */
    protected string $targetsKey = 'targets';

    // ...remaining not shown...
}
```

## Minimum and Maximum Resources

By default, the `targets` property must contain at least one resource identifier, and a maximum of 10. 
To change this, set the `$min` and `$max` properties.

```php
use Aedart\Http\Api\Requests\Resources\ProcessMultipleResourcesRequest;

class DeleteMultipleUsers extends ProcessMultipleResourcesRequest
{
    /**
     * Minimum amount of requested "targets"
     *
     * @var int
     */
    protected int $min = 1;

    /**
     * Maximum amount of requested "targets"
     *
     * @var int
     */
    protected int $max = 10;

    // ...remaining not shown...
}
```

## Authorisation

When the requested resources are found (_see [Custom Search](#customise-search-query)_), the Eloquent Collection is passed on to the `authorizeFoundRecords()` method.
You are responsible for determining how to check the current user's abilities, to determine if he/she is authorised to perform the given bulk request, for the found records.
As an example, consider the following:

```php
// ...inside your request...

public function authorizeFoundRecords(Collection $records): bool
{
    return $this->allows('bulk-destroy', [
        $this->authorisationModel(),
        $records
    ]);
}
```

## Additional Validation Rules

Overwrite the `rules()` method to add additional validation rules, should you need it.

```php
// ...inside your request...

public function rules(): array
{
    $key = $this->targetsKey();

    return array_merge(parent::rules(), [
        // E.g. to customise "targets" validation...
        "{$key}.*" => function () {
            return $this->targetIdentifierRules();
        },
        
        // Require evt. additional input
        'data' => [
            // ...not shown here...      
        ],
    ]);
}
```

## Eager-Loading

If your request requires additional relations to be eager-loaded, then you can specify them via the `with()` method.

```php
use Aedart\Http\Api\Requests\Resources\ProcessMultipleResourcesRequest;

class DeleteMultipleUsers extends ProcessMultipleResourcesRequest
{
    protected function prepareForValidation()
    {
        parent::prepareForValidation();
    
        $this->with([ 'games' ]);
    }

    // ...remaining not shown...
}
```

## Trashed (Soft-Deleted) Resources

Soft-deleted resources are not queried by default. To change this behaviour, simply set the `$withTrashed` property to `true`.

```php
use Aedart\Http\Api\Requests\Resources\ProcessMultipleResourcesRequest;

class DeleteMultipleUsers extends ProcessMultipleResourcesRequest
{
    /**
     * Include "trashed" records or not
     *
     * @var bool
     */
    protected bool $withTrashed = true;
    
    // ...remaining not shown...
}
```

## When Records are Found

The `whenRecordsAreFound()` is a hook method, which is invoked after requested resources are found, and after [authorisation check](#authorisation) has been undertaken.
You can use this method to perform post-found validation logic.

```php
// ...inside your request...

public function whenRecordsAreFound(Collection $records): void
{
    // Perform additional validation for the found records.
    // ...not shown here...
}
```

## Customise Search Query

To customise the query that is used for finding the requested resources, overwrite the `applySearch()` method.
The method is given the current query scope, the name of the table column to query, and the list of requested identifiers. 

```php
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;

// ...inside your request...

protected function applySearch(
    EloquentBuilder|Builder $query,
    string $key,
    array $targets
): EloquentBuilder|Builder
{
    // Add your custom query constraints here...
    return $query
        ->whereIn($key, $targets);
}
```

## Request Preconditions

A similar recommendation applies to this kind of request, as for [List Resources](./list-resources.md#request-preconditions).
If you do enable evaluation of preconditions, then you must consider how to generate a single and reliable Etag and/or Last Modified data for the requested resources.
