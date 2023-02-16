---
description: Http Api Resource Registrar
sidebarDepth: 0
---

# Registrar

The Api Resource `Registrar` is responsible for keeping track of each Eloquent Model's corresponding `ApiResource`.
This component is, amongst other things, used to automatically find a [relation's](./relations.md) corresponding `ApiResource`.

[[TOC]]

## Registration of Api Resources

Your registration should primarily be undertaken inside your `config/api-resources.php`. 
See [how to register Api Resource](./README.md#register-api-resource) introduction.

Nevertheless, the remaining of this sections will illustrate how to work with the `Registrar`, so that you
may use it for more advanced approaches, if such is needed.

## Obtain `Registra` instance

The `Registrar` component is bound as a singleton in the Service Container of your application.
To obtain the instance, you can use `ApiResourceRegistrarTrait`.

```php
use Aedart\Http\Api\Traits\ApiResourceRegistrarTrait;
use Illuminate\Http\Request;

class UsersController {
    use ApiResourceRegistrarTrait;
    
    public function index(Request $request){
        $registrar = $this->getApiResourceRegistrar();
        
        // ...remaining not shown...
    }
}
```

## Register single Api Resource

If you wish to manually register a single Api Resource, for an Eloquent Model, use the `set()` method.

```php
use App\Http\Resources\AddressResource;
use App\Models\Address;

$registrar->set(Address::class, AddressResource::class);
```

## Register multiple Api Resources

To register a list of Api Resources, use `register()`. The method accepts an `array` of key-values;

* key = _class path to your eloquent model_
* value = _class path to the model's corresponding Api Resource_

```php
$registrar->register([
    Address::class => AddressResource::class,
    User::class => UserResource::class,
    Book::class => BookResource::class
]);
```

## Determine if Model has an Api Resource

The `has()` method can be used to determine if a model has an Api Resource registered.
It accepts either a class path to an Eloquent Model or a Model instance.

```php
echo $registrar->has(Address::class); // 1
```

## Get Api Resource

The `get()` method returns a `string` class path to the registered Api Resource.
If no Api Resource was registered for given model, then the method returns `null`.

```php
echo $registrar->get(Address::class); // \App\Http\Resources\AddressResource
```

## Find Api Resource by Type

To find an Api Resource (_class path_) by its type, use `findResourceByType()`.
Method accepts a resource's `string` type in either singular or plural form.
If an Api Resource exists for the given type, then its class path is returned.
`Null` is returned if no Api Resource was found. 

```php
// Type in singular form
echo $registrar->findResourceByType('address'); // \App\Http\Resources\AddressResource

// Type in plural form
echo $registrar->findResourceByType('users'); // \App\Http\Resources\UserResource
```

## Find Model by Resource Type

It is also possible to find the Eloquent Model of an Api Resource, by searching for the resource type via the `findModelByType()` method.

```php
// Type in singular form
echo $registrar->findModelByType('address'); // \App\Models\Address

// Type in plural form
echo $registrar->findModelByType('users'); // \App\Models\User
```

## Remove Api Resource

Should you be required to remove an Api Resource for a given model, then you can do so via the `forget()` method.
The method will return `true` when Api Resource and successfully removed, for the given model. If not, `false` is returned.

```php
echo $registrar->forget(Address::class); // 1
```