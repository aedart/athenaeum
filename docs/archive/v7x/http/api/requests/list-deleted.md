---
description: Http Api Validated Requests - List Deleted Request
sidebarDepth: 0
---

# List Deleted

The `ListDeletedResourcesRequest` abstraction is an extended version of [List Resources request](./list-resources.md).
It is intended for when ["soft-deleted"](https://laravel.com/docs/10.x/eloquent#soft-deleting) resources must be listed.

[[TOC]]

**Example Request**

```php
use Aedart\Contracts\Filters\Builder;
use Aedart\Http\Api\Requests\Resources\ListDeletedResourcesRequest;
use App\Models\User;

class ListDeletedUsers extends ListDeletedResourcesRequest
{
    public function authorisationModel(): string|null
    {
        return User::class;
    }

    public function filtersBuilder(): string|Builder|null
    {
        return null;
    }
}
```

**Example Action**

```php
Route::get('/users/deleted', function (ListDeletedUsers $request) {
    return UserResource::collection(
        User::onlyTrashed()
            ->paginate($request->show)
    );
})->name('users.trashed');
```

## Authorisation

By default, the request will check against a `trashed` ability, for the current authenticated user.
From the above shown examples, a `users.trashed` ability is checked.

## Pagination

See [List Resources pagination section](./list-resources.md#pagination).

## Filters Builder

See [List Resources filters builder section](./list-resources.md#filters-builder).

## Request Preconditions

See [List Resources request preconditions section](./list-resources.md#request-preconditions).