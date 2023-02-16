---
description: Http Api Validated Requests - List Resources Request
sidebarDepth: 0
---

# List Resources

The `ListResourcesRequest` abstraction is intended for "index" requests in which a list of paginated resources is shown. 

[[TOC]]

**Example Request**

```php
use Aedart\Contracts\Filters\Builder;
use Aedart\Http\Api\Requests\Resources\ListResourcesRequest;
use App\Models\User;

class ListUsers extends ListResourcesRequest
{
    public function authorisationModel(): string|null
    {
        return User::class;
    }

    public function filtersBuilder(): string|Builder|null
    {
        // Request filters builder...
        return null;
    }
}
```

**Example Action**

```php
Route::get('/users', function (ListUsers $request) {
    return UserResource::collection(
        User::query()
            ->paginate($request->show)
    );
})->name('users.index');
```

## Authorisation

The `authorize()` is implemented by default. It checks if current user is granted an `index` ability for given resource.
From the above shown examples, a `users.index` ability is checked.

## Pagination

Validation of pagination query parameters is automatically performed.
To configure pagination, you can set the following properties in your request class.

```php
class ListUsers extends ListResourcesRequest
{
    /**
     * Default amount of results to be shown,
     * when none requested
     *
     * @var int
     */
    protected int $defaultShow = 15;

    /**
     * Minimum allowed value for "show" property
     *
     * @var int
     */
    protected int $showMinimum = 1;

    /**
     * Maximum allowed value for "show" property
     *
     * @var int
     */
    protected int $showMaximum = 100;

    /**
     * Name of the query parameter that contains requested page
     *
     * @var string
     */
    public string $pageKey = 'page';

    /**
     * Name of the query parameter that contains requested amount
     * to be shown per page
     *
     * @var string
     */
    public string $showKey = 'show';

    // ...remaining not shown ...
}
```

You can access pagination related properties directly on the request instance. 

```php
Route::get('/users', function (ListUsers $request) {
    $page = $request->page;
    $pageKey = $request->pageKey;
    $show = $request->show;

    $users = User::query()
            ->paginate(
                perPage: $show,
                pageName: $pageKey,
                page: $page
            );

    // ...remaining not shown...  
});
```

## Filters Builder

If your request supports [filters](../../../filters/builder.md), then you can return the class path or `Builder` instance, in the `filtersBuilder()` method.

```php
use Aedart\Contracts\Filters\Builder;
use Aedart\Http\Api\Requests\Resources\ListResourcesRequest;
use App\Filters\UserFiltersBuilder;

class ListUsers extends ListResourcesRequest
{
    // ...previous not shown ...

    public function filtersBuilder(): string|Builder|null
    {
        return UserFiltersBuilder::class;
    }
}
```

In your route or controller action, use the `applyFilters()` to apply eventual requested filters, which are available in the `$filters` attribute.

```php
Route::get('/users', function (ListUsersRequest $request) {
    return UserResource::collection(
        User::applyFilters($request->filters->all())
            ->paginate($request->show)
    );
});
```

See [Database Query Filters](../../../database/query/criteria.md) for additional information.

## Request Preconditions

Although support for Http Request Conditionals is possible for this kind of request, it is **_not recommended_**.
You will be required to compute a reliable [ETag](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/ETag) and/or [Last-Modified](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Last-Modified) date for the filtered and paginated results.
This can end up costing a lot of CPU cycles and thereby affect performance.
Therefore, no preconditions evaluation is enabled by default, for this kind of request abstraction.

Despite the above-mentioned recommendation, if you still wish to support evaluation of request preconditions, then you should consider generating a unique ETag which takes the following into consideration:

* The requested query parameters (_e.g. filters and pagination_).
* The filtered and paginated resources (_the resulting eloquent models with eventual eager-loaded relations_).
* The type of resource that is requested.

See [Show Single Resource](./show-single.md#request-preconditions) for examples of preconditions evaluation.
In addition, you should also review the source code of `\Aedart\Http\Api\Requests\Concerns\HttpConditionals` (_available in all request abstractions_).

Lastly, it might be prudent to ignore generating a `Last-Modified` date, if you enable preconditions evaluation for a collection of filtered and paginated resources.