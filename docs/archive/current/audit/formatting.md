---
description: How to Customize Audit Trails for a Model, Audit package
---

# Formatting

[[TOC]]

## Audit Trail Formatter

To customise a model's audit trail entries, create a `Formatter` class and enable it for your model.

TODO: EXAMPLE OF CUSTOM FORMATTER FOR USER CLASS

## Enable Formatter

TODO: EXAMPLE OF HOW TO ENABLE CUSTOM FORMATTER FOR USER CLASS

## Hide Attributes

TODO: EXAMPLE OF HOW TO HIDE ATTRIBUTES

## Format Attributes

TODO: EXAMPLE OF HOW TO FORMAT ORIGINAL AND CHANGED ATTRIBUTES

## Format Message

TODO: EXAMPLE OF HOW TO FORMAT MESSAGE

---------------------
TODO: REMOVE THIS

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
            ...$this->auditTimestampAttributes()
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

## Onward

For additional possibilities to format and customise audit trail entries, please review the source code of `\Aedart\Audit\Concerns\ChangeRecording`.
