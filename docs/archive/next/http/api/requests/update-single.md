---
description: Http Api Validated Requests - Update Single Resource Request
sidebarDepth: 0
---

# Update Resource

`UpdateSingleResourceRequest` is intended for when an existing resource must be updated.

[[TOC]]

**Example Request**

```php
use Aedart\Http\Api\Requests\Resources\UpdateSingleResourceRequest;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UpdateUser extends UpdateSingleResourceRequest
{
    public function findRecordOrFail(): Model
    {
        return User::findOrFail($this->route('id'));
    }

    public function mustEvaluatePreconditions(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:100'
        ];
    }
}
```

**Example Action**

```php
Route::patch('/users/{id}', function (UpdateUser $request) {
    $user = $request->record;
    $user->name = $request->validated('name');

    $user->save();

    return UserResource::make($user);
})->name('users.update');
```

## Authorisation

Authorisation checks is performed by the `authorizeFoundRecord()` method (_see source code for details_).
The request will check against a `update` ability.
From the above shown examples, a `users.update` ability is checked.

## Request Preconditions

See [Show Request](./show-single.md#request-preconditions) for additional information.