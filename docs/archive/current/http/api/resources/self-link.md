---
description: Http Api Resource Self-Link
sidebarDepth: 0
---

# Self-Link

Each Api Resource contains a self-link; a URL for showing the individual model.
This can be handy for Api Clients when they must automate retrieval of individual resources.

[[TOC]]

## Route Name

By default, the self-link is generated based on the following assumptions:

* Api Resource has a named route
* The route's name is `"[plural-resource-type].show"`, e.g. `addresses.show`

```php
use Illuminate\Support\Facades\Route;
use App\Http\Resources\AddressResource;
use App\Models\Address;

Route::get('/addresses/{id}', function ($id) {
    return new AddressResource(Address::findOrFail($id));
})->name('addresses.show');
```

If you follow a different naming convention, then you can overwrite the `resourceRouteName()` method to specify a different route name.

```php
// ...inside your Api Resource...

public function resourceRouteName(): string
{
    $type = $this->type(); // Resource type (singular form)

    return "show.{$type}";
}
```

## Custom Callback

Alternatively, you can also specify a callback for a single Api Resource instance, when you need to change or set its self-link.
This can be done by using the `withSelfLink()` method.

```php
Route::get('/addresses/{id}', function ($id) {
    return AddressResource::make(Address::findOrFail($id))
        ->withSelfLink(fn () => 'my-address-url')
})
```