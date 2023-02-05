---
description: Http Api Middleware
sidebarDepth: 0
---

# Remove Response Payload

The `RemoveResponsePayload` middleware is able to remove the response's body, if a `no_payload=1` query parameter is received in the request.

## Registration

You can register the middleware in your `app/Http/Kernel.php` file. 

```php
// ...Inside your App\Http\Kernel class 
protected $routeMiddleware = [
    'remove-payload' => \Aedart\Http\Api\Middleware\RemoveResponsePayload::class,
    
    //...remaining not shown...
];
```

## Query Parameter Name

By default, the middleware will look for a `no_payload=1` query parameter name.
However, if the name is not to your liking, then you can specify a custom name, when you register the middleware:

```php
Route::get('/users', function () {
    // ...not shown...
})->middleware(
    RemoveResponsePayload::class . ':nrp'
);
```

The `:nrp` will result in that the middleware will look for a `nrp=1` query parameter, instead of the default.