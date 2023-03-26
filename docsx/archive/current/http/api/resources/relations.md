---
description: Http Api Resource Relations
sidebarDepth: 0
---

# Relations

Similar to [Laravel's native Api Resources](https://laravel.com/docs/10.x/eloquent-resources#conditional-relationships), this package offers a way to include and represent relations (_in a fluent manner_), if they are eager-loaded for the given model. 
In this context, the representation of such relations are referred to as "relation references". 

[[TOC]]

## Simple Example

Imagine that your User model has a defined a [belongs to "Address" relation](https://laravel.com/docs/10.x/eloquent-relationships#one-to-many-inverse).
If you wish to display that relation in the model's corresponding Api Resource, you can use the `belongsToReference()` method (_inside the Api Resource class_).
The method expects a valid relation name, which must be defined in the Model.

### Model

Your Eloquent model must have desired relations defined. In this example, the `User` model defines a `BelongsTo` relation to an `Address`. 

```php

use App\Models\Address;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Model
{
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
}
```

### Api Resource

Inside the model's corresponding Api Resource, you can then create a "reference" which represents that relation.
The given "address" reference will now be display, if the relation is eager-loaded in the given model. 

```php
use Aedart\Http\Api\Resources\ApiResource;
use Illuminate\Http\Request;

class UserResource extends ApiResource
{
    public function formatPayload(Request $request): array
    {
        return [
            'id' => $this->getResourceKey(),
            'name' => $this->name,
            
            // Create reference to "address" relation
            'address' => $this->belongsToReference('address')
                ->withLabel('street'),
        ];
    }

    public function type(): string
    {
        return 'user';
    }
}
```

### Request

When loading a given model from the database, you must ensure to eager-load the relation(s) that you wish to be displayed. 

```php
use Illuminate\Support\Facades\Route;
use App\Http\Resources\UserResource;
use App\Models\User;

Route::get('/users/{id}', function ($id) {
    // Find requested user with "address" eager-loaded
    $user = User::with('address')->findOrFail($id);

    return new UserResource($user);
});
```

### Response

Finally, the JSON response will now include the eager-loaded relation.

```json
{
    "data": {
        "id": 48,
        "name": "John Smith",
        "address": {
            "id": 174,
            "name": "24924 Macey Hill Suite 432"
        }
    },
    "meta": {
        "type": "user",
        "self": "http://localhost/users/48"
    }
}
```

## Prerequisite

It is very important to understand that before you can display a relation, as previously shown, both the target and related model **MUST** have corresponding Api Resources registered.
In other words, both `User` and `Address` models must have a corresponding `ApiResource`! 

Should this not be the case, and you attempt to reference a relation for a model without a corresponding Api Resource, then a `RelationReferenceException` will be thrown.

## Primary Key of Related Model

When displaying a loaded relation, the corresponding Api Resource is used to determine the related model's primary key.
If you do not specify anything else, then only the related model's primary key will be shown.

**In the APi Resource**

```php
return [
    'id' => $this->getResourceKey(),
    'name' => $this->name,
    
    'address' => $this->belongsToReference('address'),
];
```

**Resulting JSON Response**

```json
{
    "data": {
        "id": 48,
        "name": "John Smith",
        "address": {
            "id": 174
        }
    },
    "meta": {
        "type": "user",
        "self": "http://localhost/users/48"
    }
}
```

If you wish to overwrite this behaviour and display a different value as the relation's primary identifier, then use the `usePrimaryKey()` method.
It accepts the name of the attribute to be shown as the related model's identifier, and an _optional_ display name of that identifier.

The following example will use an address' street name as the primary identifier, with a display name of `place_name`.  

**In the APi Resource**

```php
return [
    // ...previous not shown... 
    'address' => $this->belongsToReference('address')
        usePrimaryKey('street', 'place_name'),
];
```

**Resulting JSON Response**

```json
{
    "data": {
        "id": 48,
        "name": "John Smith",
        "address": {
            "place_name": "24924 Macey Hill Suite 432"
        }
    },
    "meta": {
        "type": "user",
        "self": "http://localhost/users/48"
    }
}
```

## Label

Unless you specify otherwise, only the related model's primary key will be shown, when you use a relation reference.
To make a relation more human-readable, you can choose to display a name or label for the related model.
This can be achieved by using the `withLabel()` method.

The method accepts an attribute of the related model, which will then be used as the relation reference's shown "name". 

**In the APi Resource**

```php
return [
    // ...previous not shown... 
    'address' => $this->belongsToReference('address')
        ->withLabel('street'),
];
```

**Resulting JSON Response**

```json
{
    "data": {
        "id": 48,
        "name": "John Smith",
        "address": {
            "id": 174,
            "name": "24924 Macey Hill Suite 432"
        }
    },
    "meta": {
        "type": "user",
        "self": "http://localhost/users/48"
    }
}
```

### Label's Display Name

`"name"` is the default property name when a label is shown for a relation reference.
To change this, use the `setLabelDisplayName()` method.

**In the APi Resource**

```php
return [
    // ...previous not shown... 
    'address' => $this->belongsToReference('address')
        ->withLabel('street')
        ->setLabelDisplayName('place_name')
];
```

**Resulting JSON Response**

```json
{
    "data": {
        "id": 48,
        "name": "John Smith",
        "address": {
            "id": 174,
            "place_name": "24924 Macey Hill Suite 432"
        }
    },
    "meta": {
        "type": "user",
        "self": "http://localhost/users/48"
    }
}
```

### Using a Callback

If you require a more advanced label, e.g. a combination of multiple model attributes, then you can specify a callback as argument for the `withLabel()` method.
The loaded model instance is given as the callback's argument. The callback **MUST** return a `string` or `null`.

**In the APi Resource**

```php
return [
    // ...previous not shown... 
    'address' => $this->belongsToReference('address')
        ->withLabel(function(Address $model) {
            return $model->street . ', ' . $model->city;
        })
];
```

**Resulting JSON Response**

```json
{
    "data": {
        "id": 48,
        "name": "John Smith",
        "address": {
            "id": 174,
            "name": "24924 Macey Hill Suite 432, South Eric"
        }
    },
    "meta": {
        "type": "user",
        "self": "http://localhost/users/48"
    }
}
```

## Resource Type

The `withResourceType()` can be used to display a relation's corresponding Api Resource's type.
The method accepts two arguments:

* `$show`: `bool` (_default `true`_) determine if related model's Api Resource type should be displayed.
* `$plural`: `bool` (_default `false`_) display the plural form of the Api Resource type.

**In the APi Resource**

```php
return [
    // ...previous not shown... 
    'address' => $this->belongsToReference('address')
        ->withResourceType(true, true)
];
```

**Resulting JSON Response**

```json
{
    "data": {
        "id": 48,
        "name": "John Smith",
        "address": {
            "id": 174,
            "type": "addresses"
        }
    },
    "meta": {
        "type": "user",
        "self": "http://localhost/users/48"
    }
}
```

### Display Name

To change the `"type"` property name to something else, use the `setResourceTypeDisplayName()` method.

**In the APi Resource**

```php
return [
    // ...previous not shown... 
    'address' => $this->belongsToReference('address')
        ->withResourceType()
        ->setResourceTypeDisplayName('kind')
];
```

**Resulting JSON Response**

```json
{
    "data": {
        "id": 48,
        "name": "John Smith",
        "address": {
            "id": 174,
            "kind": "address"
        }
    },
    "meta": {
        "type": "user",
        "self": "http://localhost/users/48"
    }
}
```

## Self-link

You may also display a "self-link" to the related resource, via the `withSelfLink()` method.

**In the APi Resource**

```php
return [
    // ...previous not shown... 
    'address' => $this->belongsToReference('address')
        ->withResourceType()
        ->withSelfLink()
];
```

**Resulting JSON Response**

```json
{
    "data": {
        "id": 48,
        "name": "John Smith",
        "address": {
            "id": 174,
            "type": "address",
            "self": "http://localhost/addresses/174"
        }
    },
    "meta": {
        "type": "user",
        "self": "http://localhost/users/48"
    }
}
```

### Display Name

To change the self-link's display name (_`"self"` property_), use `setSelfLinkDisplayName()`.

**In the APi Resource**

```php
return [
    // ...previous not shown... 
    'address' => $this->belongsToReference('address')
        ->withResourceType()
        ->withSelfLink()
        ->setSelfLinkDisplayName('link')
];
```

**Resulting JSON Response**

```json
{
    "data": {
        "id": 48,
        "name": "John Smith",
        "address": {
            "id": 174,
            "type": "address",
            "link": "http://localhost/addresses/174"
        }
    },
    "meta": {
        "type": "user",
        "self": "http://localhost/users/48"
    }
}
```

## Additional Attributes and Formatting

In situations when you must display additional properties or perhaps reformat the entire relation reference's output value, use the `withAdditionalFormatting()` method.
The callback receives three arguments:

* `$output`: `array` : the final output value of the relation reference.
* `$model`: `Model` : the related Eloquent Model. 
* `$resource`: `RelationReference` : the relation reference instance.

**Note**: _The callback MUST return a value to be used as the relation reference's output value!_

**In the APi Resource**

```php
return [
    // ...previous not shown... 
    'address' => $this->belongsToReference('address')
        ->withResourceType()
        ->withAdditionalFormatting(function(array $output, Address $model) {
            $output['kind'] = $output['type'];
            unset($output['type']);
            
            $output['place'] = $model->street . ' - ' . $model->city;
            
            return $output;
        });
];
```

**Resulting JSON Response**

```json
{
    "data": {
        "id": 48,
        "name": "John Smith",
        "address": {
            "id": 174,
            "place": "24924 Macey Hill Suite 432, South Eric",
            "kind": "address"
        }
    },
    "meta": {
        "type": "user",
        "self": "http://localhost/users/48"
    }
}
```

## When Relation not available

When a related model is not loaded or perhaps not available (_e.g. a nullable relation_), then `null` is displayed by default.
However, if you desire a different value to be shown for a relation that is not loaded or not available, then you can specify a custom value or callback to be invoked, via the `defaultTo()` method. 

**In the APi Resource**

```php
return [
    // ...previous not shown... 
    'address' => $this->belongsToReference('address')
        ->defaultTo('n/a')
];
```

**Resulting JSON Response**

```json
{
    "data": {
        "id": 48,
        "name": "John Smith",
        "address": "n/a"
    },
    "meta": {
        "type": "user",
        "self": "http://localhost/users/48"
    }
}
```

### Using a Callback

If you desire a more complex value to be shown, when a relation is not available, then specify a callback as `defaultTo()`'s argument.

**In the APi Resource**

```php
return [
    // ...previous not shown... 
    'address' => $this->belongsToReference('address')
        ->defaultTo(function() {
            return [
                'id' => null,
                'type' => 'address'
            ];
        }),
];
```

**Resulting JSON Response**

```json
{
    "data": {
        "id": 48,
        "name": "John Smith",
        "address": {
            "id": null,
            "type": "address"
        }
    },
    "meta": {
        "type": "user",
        "self": "http://localhost/users/48"
    }
}
```

## Supported Relation Types

The following types of Eloquent relations are supported. You may also create your own relation reference, if the default provided do not satisfy your needs (_custom relations are illustrated later in this section_).

### Belongs To / Has One

For `BelongsTo` or `HasOne` relation types, you can use the following relation references:

* `belongsToReference()`
* `hasOneReference()`

They share similar functionality and are able to represent a single related model.

### Belongs To Many / Has Many

If you want to display a reference for a `BelongsToMany` or `HasMany` type of relation, then you can do so via the following:

* `belongsToManyReference()`
* `hasManyReference()`

These relation references are able to display a list of related models. Consider the following example:

**In the APi Resource**

```php
return [
    // ...previous not shown... 
    'roles' => $this->belongsToManyReference('roles')
        ->withLabel('name')
        ->withSelfLink()
        ->withResourceType();
];
```

**Resulting JSON Response**

```json
{
    "data": {
        "id": 34,
        "name": "Retta Altenwerth Jr.",
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

**Caution**: _Although the `belongsToManyReference()` and `hasManyReference()` allow showing multiple related models, they could impose a huge impact on your application's performance if too many records are loaded from the database._
_How you choose to eager-load "belongs to many" or "has many" kind of relations is entirely your responsibility..._

## Custom Relation References

To create your own relation reference, you can extend the `BaseRelationReference` abstraction.

```php
use Aedart\Http\Api\Resources\Relations\BaseRelationReference;

class MyCustomAddressRelation extends BaseRelationReference
{
    public function __construct(mixed $resource)
    {
        // Ensure to invoke parent constructor
        parent::__construct($resource, 'address'); // 2nd arg. is name of relation!
        
        // Example: Use existing "default" formatting callback... 
        $this->asSingleModel();
        
        // Example: always show the resource type:
        $this->mustShowResourceType();
    }
}
```

**In the APi Resource**

```php
return [
    // ...previous not shown... 
    'address' => (new MyCustomAddressRelation($this))
        ->withLabel('street')
];
```
