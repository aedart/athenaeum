---
description: Http Api Resource
sidebarDepth: 0
---

# Introduction

> "_[...] A resource class represents a single model that needs to be transformed into a JSON structure [...]_" ([source Laravel docs.](https://laravel.com/docs/11.x/eloquent-resources#concept-overview))

The `ApiResource` is an extended / adapted version of Laravel's [`JsonResource`](https://laravel.com/docs/11.x/eloquent-resources#concept-overview).
It ensures that each Api Resource that you create has a "type" and a "self" link.
Additionally, all of your Api Resources are registered in a [Registrar](./registrar.md).

### How to create an Api Resource

Extend the `ApiResource` and implement the `formatPayload()` and `type()` methods.

```php
use Aedart\Http\Api\Resources\ApiResource;
use Illuminate\Http\Request;
use App\Models\Address;

/**
 * @mixin Address
 */
class AddressResource extends ApiResource
{
    public function formatPayload(Request $request): array
    {
        return [
            'id' => $this->id,
            'street' => $this->street,
            'postal_code' => $this->postal_code,
            'city' => $this->city
        ];
    }

    public function type(): string
    {
        // Resource's type name (singular form)
        return 'address';
    }
}
```

## Register Api Resource

Once you have created your Api Resource, you must register it in the [Registrar](./registrar.md).
The easiest way of doing so, is by defining a new key-value pair inside your `config/api-resources.php` configuration file.

```php
use App\Models\Address;
use App\Http\Resources\AddressResource;

return [

    /*
     |--------------------------------------------------------------------------
     | Api Resources
     |--------------------------------------------------------------------------
    */

    'registry' => [

        Address::class => AddressResource::class,

    ],
];
```

## Usage

After your Api Resource has been registered, you can use it as you normally would with Laravel's `JsonResource`.

```php
use Illuminate\Support\Facades\Route;
use App\Http\Resources\AddressResource;
use App\Models\Address;

Route::get('/addresses/{id}', function ($id) {
    return new AddressResource(Address::findOrFail($id));
});
```

The resulting JSON output will be something similar to this:

```json
{
    "data": {
        "id": 5,
        "street": "24924 Macey Hill Suite 432",
        "postal_code": "17092",
        "city": "South Eric"
    },
    "meta": {
        "type": "address",
        "self": "http://localhost/addresses/5"
    }
}
```