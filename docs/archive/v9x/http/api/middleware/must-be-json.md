---
description: Http Api Middleware
sidebarDepth: 0
---

# Request Must Be Json

The `RequestMustBeJson` middleware ensures that a request's `Content-Type` and `Accept` headers are of a JSON type, e.g. `application/json`.
When a client performs a request that is not of a valid JSON type, then this middleware will reject the request and result in a HTTP [400 Bad Request](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/400) response.

## Registration

Register the middleware in your `app/Http/Kernel.php` file.

```php
// ...Inside your App\Http\Kernel class 
protected $routeMiddleware = [
    'must-be-json' => \Aedart\Http\Api\Middleware\RequestMustBeJson::class,
    
    //...remaining not shown...
];
```

Assign the middleware to the routes that you wish to use it.

```php
Route::get('/users', function () {
    // ...not shown...
})->middleware('must-be-json');
```