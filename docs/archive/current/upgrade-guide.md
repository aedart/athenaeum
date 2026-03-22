---
description: Athenaeum Packages Upgrade Guide
sidebarDepth: 1
---

# Upgrade Guide

## From version 9.x to 10.x

[[TOC]]

### PHP version `8.4` required

You need PHP `v8.4` or higher to run Athenaeum packages.

**Note**: _PHP `v8.5` is supported!_

### Laravel `v13.x`

Please read Laravel's [upgrade guide](https://laravel.com/docs/13.x/upgrade), before continuing here.

### Audit Trail

Several components and methods concerning audit trail formatting have been deprecated.
Formatting of audit trail entries has been extracted into their own `Formatter` classes.
While the previous formatting logic is still supported in the current version (`v10.x`), it is highly recommended that you refactor.

**_:x: previously_**

```php
namespace Acme\Models;

use Aedart\Audit\Concerns\ChangeRecording;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use ChangeRecording;
    
    public function formatOriginalData(array|null $filtered, string $type): array|null
    {
        // ...formatting not shown here...
        return $filtered;
    }
    
    public function formatChangedData(array|null $filtered, string $type): array|null
    {
        // ...formatting not shown here...
        return $filtered;
    }
}
```

**_:heavy_check_mark: Now_**

```php
namespace Acme\Models;

use Aedart\Contracts\Audit\Formatter;
use Aedart\Audit\Concerns\ChangeRecording;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use ChangeRecording;
    
    public function auditTrailRecordFormatter(): string|Formatter|null
    {
        // Formatting of audit trail entry moved into custom "formatter"... 
        return UserAuditTrailFormatter::class;
    }
}
```

Please review the [Audit Trail Formatting](./audit/formatting.md) documentation for additional information.

### Field Criteria Logical Operators

The logical operator constants (`FieldCriteria::AND` and `FieldCriteria::OR`) have been deprecated and replaced by a new `LogicalOperator` enum.
If you have custom query filters that inherit from `FieldCriteria`, then you must change your comparison of the logical operator.

**_:x: previously_**

```php
use Aedart\Database\Query\FieldFilter;
use Aedart\Contracts\Database\Query\FieldCriteria;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;

class StringFilter extends FieldFilter
{
    public function apply(Builder|EloquentBuilder $query)
    {
        if ($this->logical() === FieldCriteria::OR) {
            return $query->orWhere(
                $this->field(),
                $this->operator(),
                $this->value()
            );
        }

        return $query->where(
            $this->field(),
            $this->operator(),
            $this->value()
        );
    }
}
```

**_:heavy_check_mark: Now_**

```php{2,10}
use Aedart\Database\Query\FieldFilter;
use Aedart\Contracts\Database\Query\Operators\LogicalOperator
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;

class StringFilter extends FieldFilter
{
    public function apply(Builder|EloquentBuilder $query)
    {
        if ($this->logical() === LogicalOperator::OR) {
            return $query->orWhere(
                $this->field(),
                $this->operator(),
                $this->value()
            );
        }

        return $query->where(
            $this->field(),
            $this->operator(),
            $this->value()
        );
    }
}
```

You can also use the `buildFor()` utility method, instead of performing manual comparison of the logical operator.

```php
use Aedart\Database\Query\FieldFilter;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;

class StringFilter extends FieldFilter
{
    public function apply(Builder|EloquentBuilder $query)
    {
        return $this->buildFor(
            and: fn () => $query->where(
                    $this->field(),
                    $this->operator(),
                    $this->value()
                ),
            or: fn () => $query->orWhere(
                    $this->field(),
                    $this->operator(),
                    $this->value()
                ), 
        );
    }
}
```

### `Paths` Container now inherits from `ArrayDto`

The `Paths` container now inherits from `ArrayDto`. It no longer depends on the deprecated / removed "Aware-of" components.
All mutator methods (_setters_) have been removed. If you wish to manually set a directory path, you must do so by setting the property's value directly

**_:x: previously_**

```php
use Aedart\Core\Helpers\Paths;

$paths = new Paths();
$paths->setConfigPath(getcwd() . DIRECTORY_SEPARATOR . 'environments');

```

**_:heavy_check_mark: Now_**

```php
use Aedart\Core\Helpers\Paths;

$paths = new Paths();
$paths->configPath = getcwd() . DIRECTORY_SEPARATOR . 'environments';
```

### File Stream Locks

The `LockTypes` (_interface_) has been replaced with a new `LockType` enum.

**_:x: previously_**

```php
use Aedart\Contracts\Streams\Locks\LockTypes;
```

**_:heavy_check_mark: Now_**

```php
use Aedart\Contracts\Streams\Locks\LockType;
```

Your file stream "transactions" configuration, in `config/streams.php`, _SHOULD_ be modified to use the `LockType` enum.     

```php
return [

    // ...previous not shown...

    'transactions' => [

        'default' => [
            'driver' => \Aedart\Streams\Transactions\Drivers\CopyWriteReplaceDriver::class,
            'options' => [
                'maxMemory' => 5 * \Aedart\Contracts\Streams\BufferSizes::BUFFER_1MB,
                'lock' => [
                    'enabled' => true,
                    'profile' => env('STREAM_LOCK', 'default'),

                    // Use LockType enum value here...
                    'type' => \Aedart\Contracts\Streams\Locks\LockType::EXCLUSIVE,

                    'timeout' => 0.5,
                ],
                
                // ...remaining not shown ...
            ]
        ]
    ]
];
```

### Http Client Debugging and Logging

The Http Message `Types` (_interface_) has been replaced with a new `Type` enum. This affects all custom debugging
and logging callbacks, in the Http Client. Previously a string value from the constants defined in the `Types` interface
was used. Now, the `Type` enum case is passed on to the callbacks. Affected methods are:

* `log()`
* `debug()`
* `dd()`

**_:x: previously_**

```php
use Aedart\Contracts\Http\Messages\Type;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Psr\Http\Message\MessageInterface;

$response = $client
        ->where('date', 'today')
        ->debug(function(string $type, MessageInterface $message, Builder $builder) {
            if ($type === 'request') {
                // debug a request...
            } else {
                // debug response...
            }       
        })
        ->get('/weather');
```

**_:heavy_check_mark: Now_**

```php
use Aedart\Contracts\Http\Messages\Type;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Psr\Http\Message\MessageInterface;

$response = $client
        ->where('date', 'today')
        ->debug(function(Type $type, MessageInterface $message, Builder $builder) {
            if ($type === Type::REQUEST) {
                // debug a request...
            } else {
                // debug response...
            }       
        })
        ->get('/weather');
```

### Set-Cookies SameSite

The predefined [SameSite](https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Headers/Set-Cookie#samesitesamesite-value) constants in 
`SetCookie` have been deprecated. Use the `SameSite` enum cases instead.
The `sameSite()` and `getSameSite()` methods are affected.

**_:x: previously_**

```php
use Aedart\Http\Cookies\SetCookie;

$cookie = new SetCookie()->sameSite('lax');

$policy = $cookie->getSameSite() // string 'lax'
```

**_:heavy_check_mark: Now_**

```php
use Aedart\Contracts\Http\Cookies\SameSite;
use Aedart\Http\Cookies\SetCookie;

$cookie = new SetCookie()->sameSite('lax'); 

$policy = $cookie->getSameSite() // SameSite::LAX enum case
```

The `sameSite()` also accepts an enum case.

```php
use Aedart\Contracts\Http\Cookies\SameSite;
use Aedart\Http\Cookies\SetCookie;

$cookie = new SetCookie()->sameSite(SameSite::STRICT); 

$policy = $cookie->getSameSite() // SameSite::STRICT enum case
```

#### Secure Flag

If you set `SameSite::NONE` as the same-site value, then the `secure` flag is automatically set to `true`;  

**_:x: previously_**

```php
use Aedart\Http\Cookies\SetCookie;

$cookie = new SetCookie()
    ->secure(false)
    ->sameSite('none'); 

$secure = $cookie->isSecure() // false
```

**_:heavy_check_mark: Now_**

```php
use Aedart\Http\Cookies\SetCookie;

$cookie = new SetCookie()
    ->secure(false)
    ->sameSite('none'); 

$secure = $cookie->isSecure() // true
```

### Circuit Breaker State Identifiers

The state identifiers (_constants_) defined in `\Aedart\Contracts\Circuits\CircuitBreaker` have been deprecated. A new `Identifier` enum has replaced them.
Consequently, the `id()` method of circuit breaker's `State` now returns an enum case. Unless you have logic that directly depends on the circuit breaker's
state identifier, then this change _should_ not affect your.

**_:x: previously_**

```php
use Aedart\Contracts\Circuits\CircuitBreaker;

/** @var CircuitBreaker $circuitBreaker */
$id = $circuitBreaker->state()->id();

echo gettype($id); // integer
var_export($id === CircuitBreaker::CLOSED); // true
```

**_:heavy_check_mark: Now_**

```php
use Aedart\Contracts\Circuits\States\Identifier;
use Aedart\Contracts\Circuits\CircuitBreaker;

/** @var CircuitBreaker $circuitBreaker */
$id = $circuitBreaker->state()->id();

echo gettype($id); // object
var_export($id === Identifier::CLOSED); // true
```

### DTO Deprecation

The `Dto` abstraction has been deprecated. Please use the `ArrayDto` abstraction instead.

**_:x: previously_**

```php
use Aedart\Dto\Dto;

class Person extends Dto
{
    protected string|null $name = '';
    protected int|null $age = 0;
}
```

**_:heavy_check_mark: Now_**

```php
use Aedart\Dto\ArrayDto;

class Person extends ArrayDto
{
    protected array $allowed = [
        'name' => 'string|null',
        'age' => 'int|null'
    ];
}
```

See [package documentation](./dto/usage.md) for additional examples.

### Removed "Aware-of" Components

The "aware-of" components that were located in `Aedart\Contracts\Support\Properties` and `Aedart\Support\Properties` have been removed.
They have been deprecated since `v9.x`. No replacements are offered!

If you depend on any of those components, please review the source code of previous versions of the Athenaeum Support package.

### Other Deprecated Components

Several other deprecated components have also been removed. Please review the `CHANGELOG.md` for additional details.

## Onward

More extensive details can be found in the [changelog](https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md).
