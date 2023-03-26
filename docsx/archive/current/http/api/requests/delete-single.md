---
description: Http Api Validated Requests - Delete Single Resource Request
sidebarDepth: 0
---

# Delete Resource

For requests that are intended to delete or [soft-delete](https://laravel.com/docs/10.x/eloquent#soft-deleting) a resource, you can use the `DeleteSingleResourceRequest` abstraction.

[[TOC]]

**Example Request**

```php
use Aedart\Http\Api\Requests\Resources\DeleteSingleResourceRequest;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class DeleteUser extends DeleteSingleResourceRequest
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
Route::delete('/users/{id}', function (DeleteUser $request) {
    $user = $request->record;
    
    // E.g. soft-delete
    $user->delete();

    return UserResource::make($user);
})->name('users.destroy');
```

## Authorisation

Authorisation checks is performed by the `authorizeFoundRecord()` method (_see source code for details_).
The request will check against a `destroy` ability.
From the above shown examples, a `users.destroy` ability is checked.

## Request Preconditions

See [Show Request](./show-single.md#request-preconditions) for additional information.