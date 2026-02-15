---
description: How to Configure Models, Audit package
---

# Recording

[[TOC]]

## Enable Recording

In your Eloquent model, add the `RecordsChanges` trait, to enable automatic recording of changes.

```php
namespace Acme\Models;

use Illuminate\Database\Eloquent\Model;
use Aedart\Audit\Concerns;

class Category extends Model
{
    use Concerns\ChangeRecording;
}
```

Whenever you change the model's attributes and save the changes, a new audit trail record will be stored in the database.

```php
$category = new Category();
$category->name = 'Cars';
$category->save(); // change is automatically recorded.
```

Behind this scene, events containing original and change attributes are dispatched.
See the [Events chapter](./events.md) for additional information.

## Retrieve Changes

To retrieve an audit trail for your model, use the `recordedChanges()` [relationship method](https://laravel.com/docs/13.x/eloquent-relationships).

```php
$changes = $category->recordedChanges()->first();

dump($changes->toArray());
```

The above example will output an entry similar to:

```txt
Array
(
    [id] => 1
    [user_id] => 
    [auditable_type] => Acme\Models\Category
    [auditable_id] => 1
    [type] => created
    [message] => Recording created event
    [original_data] => null
    [changed_data] => Array
        (
            [name] => Cars
        )
    [performed_at] => 2026-02-07T11:06:39.000000Z
    [created_at] => 2026-02-07T11:06:39.000000Z
)
```

## Specify custom message for a change

If you wish to associate a custom message with a change , use the `performChange()` method.

```php
$category->performChange(function(Category $model) {
    $model->description 'Contains information about cars';
    $model->save();
}, 'Changed incorrect description'); // Custom message in audit trail entry

// Later...
$changes = $category->recordedChanges()->latest()->first();

dump($changes->toArray());
```

The above example will output an entry similar to:

```txt
Array
(
    [id] => 4
    [user_id] => 
    [auditable_type] => Acme\Models\Category
    [auditable_id] => 1
    [type] => updated
    [message] => Changed incorrect description
    [original_data] => 
        (
            [description] => Information about persons
        )
    [changed_data] => Array
        (
            [description] => Contains information about cars
        )
    [performed_at] => 2026-02-07T12:45:03.000000Z
    [created_at] => 2026-02-07T12:45:03.000000Z
)
```

## Skip a Recording

When you need to perform an operation without recording it, then you can use `withoutRecording()`.
It accepts a callback that is invoked with the model instance as argument.

```php
$category->withoutRecording(function($myCategoryModel) {
    $myCategoryModel->name = 'Products';
    $myCategoryModel->save();
});
```

The above shown example is the equivalent to the using `skipRecordingNextChange()` and `recordNextChange()` (_resetting the skip recording state_):

```php
$category
    ->skipRecordingNextChange()
    ->fill([
        'name' => 'Products',
    ])
    ->save();

$category->recordNextChange();
```

::: tip Note
[Eloquent events](https://laravel.com/docs/13.x/eloquent#events), e.g. 'saving', 'saved', 'deleting'...etc, are still dispatched when you skip recording changes.
:::

## Formatting

See the [Formatting chapter](./formatting.md) for more information.
