---
description: About the Http API Package
sidebarDepth: 0
---

# Http API

_**Available since** `v6.5.x`_

Opinionated utilities to help shape and format your API, using [Laravel's API Resources](https://laravel.com/docs/9.x/eloquent-resources). 

## Example

The following example shows an "API Resource", for an Eloquent User model.

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
            'roles' => $this->belongsToManyReference('roles')
                ->withLabel('name')
                ->withSelfLink()
                ->withResourceType();
        ]);
    }

    public function type(): string
    {
        return 'user';
    }
}
```

When a response is returned for a single user, the following JSON will be output:

```json
{
    "data": {
        "id": 34,
        "name": "Retta Altenwerth Jr.",
        "created_at": "2022-10-21T14:51:43+00:00",
        "updated_at": "2022-10-21T14:51:43+00:00",
        "roles": [
            {
                "id": 23,
                "name": "Machine Operator",
                "type": "role",
                "self": "http://localhost/roles/23"
            },
            {
                "id": 56,
                "name": "File Clerk",
                "type": "role",
                "self": "http://localhost/roles/56"
            }
        ]
    },
    "meta": {
        "type": "user",
        "self": "http://localhost/users/34"
    }
}
```
