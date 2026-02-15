---
description: How to Customize Audit Trails for a Model, Audit package
---

# Formatting

[[TOC]]

## Audit Trail Formatter

To customise a model's audit trail entries, create a `Formatter` class and enable it for your model.

```php
namespace Acme\Models\Users\Audit;

use Aedart\Audit\Formatters\BaseFormatter;

class UserAuditTrailFormatter extends BaseFormatter
{
    // ...remaining not shown here...
}
```

### Enable Formatter

Specify your formatter's classpath in the `auditTrailRecordFormatter()` method, inside your model. 

```php
namespace Acme\Models;

use Acme\Models\Users\Audit\UserAuditTrailFormatter;
use Aedart\Contracts\Audit\Formatter;
use Aedart\Audit\Concerns\ChangeRecording;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use ChangeRecording;
    
    public function auditTrailRecordFormatter(): string|Formatter|null
    {
        return UserAuditTrailFormatter::class;
    }
}
```

## Hide Attributes

Use the `hide()` method to prevent specific model attributes from being recorded in the audit trail. 

```php{9-12}
use Illuminate\Database\Eloquent\Model;

class UserAuditTrailFormatter extends BaseFormatter
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
        
        $this->hide([
            'last_login',
            'updated_at'
        ]);
    }
}
```

::: tip Default hidden
If you do not specify any hidden attributes in your formatter, then the following attributes are automatically marked
as hidden:
* [Hidden Attribute (_inside your Model_)](#hidden-attributes-in-model)
* [Default Timestamps](#timestamps)
:::

### Hidden attributes in Model

Regardless of what attributes you mark as hidden in your formatter, the model's hidden attributes are
always excluded from audit trail entries.

```php{6-9}
class User extends Authenticatable
{
    use ChangeRecording;
    
    // These attributes are automaticall excluded in the audit trail!
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    //...remaining not shown
}
```

### Timestamps

When you do mark certain attributes to be hidden from audit trail entries and also wish to hide your model's "regular"
timestamps (_`created_at`, `updated_at` and `deleted_at`_), then you can obtain these using the `timestampAttributes()`
method.

```php{9-13}
use Illuminate\Database\Eloquent\Model;

class UserAuditTrailFormatter extends BaseFormatter
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
        
        $this->hide([
            $model->getKeyName(),
            'last_login',
            ...$this->timestampAttributes()
        ]);
    }
}
```

## Format Attributes

To format your model's attributes, use the `formatOriginal()` and `formatChanged()` methods.  
Both methods support the following arguments:

* `$data`: _The original or changed attributes, if available._
* `$type`: _The event type, e.g. `created`, `updated`, `deleted`, `restored`...etc._

For the sake of simplicity, the following example uses the same formatting for both the "original" and "changed" attributes. 

```php
class UserAuditTrailFormatter extends BaseFormatter
{
    // ...previous not shown...
    
    public function formatOriginal(array|null $data, string $type): array|null
    {
        return $this->applyFormatting($data, $type);
    }
    
    public function formatChanged(array|null $data, string $type): array|null
    {
        return $this->applyFormatting($data, $type);
    }
    
    /**
     * Your custom formatting method... 
     * 
     * @param array|null $data
     * @param string $type Ignored in this example...
     * 
     * @return array|null
     */
    public function applyFormatting(array|null $data, string $type): array|null
    {
        if (!isset($data)) {
            return null;
        }
        
        if (array_key_exists('job_id')) {
            $data['job'] = $this->getModel()->job->name;
            unset($data['job_id']);
        }
        
        return $data;
    }
}
```

## Format Message

Depending on the circumstances, a change that results in a new audit trail entry might contain a custom message.
The message can be modified via the `formatMessage()` method.

It accepts the following arguments:

* `$type`: _The event type, e.g. `created`, `updated`, `deleted`, `restored`...etc._
* `$message`: _Eventual message associated with the change._

```php
use \Aedart\Contracts\Audit\Types;

class UserAuditTrailFormatter extends BaseFormatter
{
    // ...previous not shown...
    
    public function formatMessage(
        string $type,
        string|null $message = null
    ): string|null
    {
        // Use the provided message, if any... 
        if (isset($message)) {
            return $message;
        }
    
        // Provide a default message to be associated with the change...
        return match($type) {
            Types::CREATED => 'New user account was created',
            Types::UPDATED => 'User account was changed',
            Types::DELETED, Types::FORCE_DELETED => 'User account has been deleted',
            default => "{$type} event occurred, user account changed..."
        }
    }
}
```

## Omit Changes for specific Events

In some situations, it might not be prudent to store any attributes (_original or changed_), in the audit trail entry.
You can prevent all attributes from being stored in an entry, by using the `omit()` method.
It accepts the following arguments:

* `$types`: _The event type(s), e.g. `created`, `updated`, `deleted`, `restored`...etc._

```php{9}
use Illuminate\Database\Eloquent\Model;

class UserAuditTrailFormatter extends BaseFormatter
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
        
        $this->omit('my-custom-event');
    }
}
```

::: tip Default Behaviour
By default, changes are omitted for the following events:
* `deleted`
* `force-deleted`
* `restored`
:::

## Onward

For additional possibilities to format and customise audit trail entries, please review the source code of `\Aedart\Audit\Formatters\BaseFormatter`.
