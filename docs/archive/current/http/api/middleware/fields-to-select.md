---
description: Http Api Middleware
sidebarDepth: 0
---

# Capture Fields To Select

The `CaptureFieldsToSelect` middleware is responsible for capturing requested fields or properties that should be returned by an Api Resource.

Middleware class path: `\Aedart\Http\Api\Middleware\CaptureFieldsToSelect`

## How it works

When a client adds a "select" query parameter, e.g. `/users?select=field_a,field_b,field_c`, then the middleware will automatically capture the requested fields and make them available to the Api Resource in question.
Once the request is processed and the Api Resource instance is created, the resulting JSON response will only contain the requested fields.

Imagine that a client requests the following `GET /users?select=id,name` and you have the following Api Resource defined for a User model:

```php
use Aedart\Http\Api\Resources\ApiResource;
use Illuminate\Http\Request;

class UserResource extends ApiResource
{
    public function formatPayload(Request $request): array
    {
        return $this->withTimestamps([
            'id' => $this->getResourceKey(),
            'name' => $this->name,
            'age' => $this->age,
            'job_title' => $this->job_title,
            'address' => $this->belongsToReference('address')
                ->withLabel('street')
        ]);
    }

    public function type(): string
    {
        return 'user';
    }
}
```

And the following route / request handler...

```php
use Illuminate\Support\Facades\Route;
use App\Http\Resources\UserResource;
use App\Models\User;

Route::get('/users', function () {
    $users = Users::all();
    
    return UserResource::collection($users);
});
```

Then the resulting JSON response will only contain the requested fields.
Notice that only the `id` and `name` properties from the Api Resource is returned.

**Note**: _The "meta" property is always included, unless otherwise defined on the actual Api Resource instance._

```json
{
    "data": [
        {
            "id": 23,
            "name": "James",
            "meta": {
                "type": "user",
                "self": "http://localhost/users/23"
            }
        },
        {
            "id": 24,
            "name": "Alice",
            "meta": {
                "type": "user",
                "self": "http://localhost/users/24"
            }
        },
        {
            "id": 25,
            "name": "Tina",
            "meta": {
                "type": "user",
                "self": "http://localhost/users/25"
            }
        }
    ],
    "meta": {
        "first": "http://localhost/users?page=1",
        "last": "http://localhost/users?page=1",
        "prev": null,
        "next": null,
        "self": "http://localhost/users",
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "per_page": 10,
        "to": 10,
        "total": 3
    }
}
```