---
description: How to Configure Models, Audit package
---

# Recording

[[TOC]]

## Enable Recording Changes

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

## Retrieve Audit Trail

To retrieve an audit trail, for your model, you can use the `recordedChanges()` [relationship method](https://laravel.com/docs/11.x/eloquent-relationships).

```php
$changes = $category
    ->recordedChanges()
    ->first();
```

## Customise Recorded Changes

There are a number of ways that you can customise the data / attributes that will be recorded. In this section, some of them are briefly introduced.

### Hide Attributes

If your model processes sensitive attributes, e.g. passwords, and you do not wish to be included in an audit trail entry, then you can hide it by defining it in the `$hiddenInAuditTrail` property.

```php
class User extends Model
{
    use Concerns\ChangeRecording;
    
    protected array|null $hiddenInAuditTrail = [
        'password'
    ];
}
```

Alternatively, you may also define attributes to be hidden by overwriting the `attributesToHideForAudit()` method.

```php
class User extends Model
{
    use Concerns\ChangeRecording;
    
    public function attributesToHideForAudit(): array
    {
        return [
            'password',
            'token',
            // ...etc
        ];
    }
}
```

### Format Attributes

The `formatChangedData()` enables you to format attributes before they are stored within an audit trail record.
The first argument contains the filtered attributes (_attributes intended to be saved in audit trail record_).
The second argument (_$type_) is the name of the event, e.g. `created, updated, deleted, restored, force-deleted... etc`.

```php
class Category extends Model
{
    use Concerns\ChangeRecording;
    
    public function formatChangedData(array|null $filtered, string $type): array|null
    {
        if (isset($filtered['name'])) {
            $filtered['name'] = strtolower($filtered['name']);
        }
        
        return $filtered;
    }
}
```

## Skip a Recording

In situations when you wish to skip recording an audit trail entry, e.g. for a single operation, use the `skipRecordingNextChange()` method.

```php{2}
$category
    ->skipRecordingNextChange()
    ->fill([
        'name' => 'Products',
    ])
    ->save();
```

## Onward

For additional possibilities to format and customise audit trail entries, please review the source code of `\Aedart\Audit\Concerns\ChangeRecording`.
