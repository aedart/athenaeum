---
description: Athenaeum Packages Upgrade Guide
sidebarDepth: 1
---

# Upgrade Guide

## From version 7.x to 8.x

[[TOC]]

### PHP version `8.2` required

You need PHP `v8.2` or higher to run Athenaeum packages.

**Note**: _PHP `v8.3` is supported!_

### Laravel `v11.x`

Please read Laravel's [upgrade guide](https://laravel.com/docs/11.x/upgrade), before continuing here.

### Anti-Virus Default Scanner

In version Athenaeum `v7.x`, a `NullScanner` was returned as the default scanner, when no profile was specified.
The default scanner has now been changed to `ClamAv`, when no profile is specified.

```php
use Aedart\Antivirus\Facades\Antivirus;

$scanner = Antivirus::profile(); // ClamAv
```

You can change this behaviour by editing your `config/antivirus.php` configuration file.

### Validated API Request `after()`

The `ValidatedApiRequest` no longer overwrites Laravel's "class based `after()` validation rules". [#168](https://github.com/aedart/athenaeum/issues/168), [#167](https://github.com/aedart/athenaeum/issues/167).
Now, you need to overwrite the `afterValidation()`, if you wish to perform post validation logic. 

**_:x: previously_**

```php
namespace Acme\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListUsersRequest exends FormRequest
{
    public function after(Validator $validator)
    {        
        // ...not shown
    }
}
```

**_:heavy_check_mark: Now_**

```php
namespace Acme\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListUsersRequest exends FormRequest
{
    public function afterValidation(Validator $validator)
    {        
        // ...not shown
    }
}
```

### Flysystem

The `RecordTypes` and `Visibility` interface has been converted into an [enum](https://www.php.net/manual/en/language.types.enumerations.php),
in `\Aedart\Contracts\Flysystem\Db` (_contributed by [Trukes](https://github.com/Trukes)_).
This change _should not_ affect your existing code, unless you are directly dependent on previous `const` values in
the defined interfaces. If that is the case, then you might have to explicitly require the enum case's
[`value`](https://www.php.net/manual/en/language.enumerations.backed.php).  

**_:x: previously_**

```php
use Aedart\Contracts\Flysystem\Visibility;

$visibility = Visibility::PRIVATE; // private
```

**_:heavy_check_mark: Now_**

```php
use Aedart\Contracts\Flysystem\Visibility;

$visibility = Visibility::PRIVATE->value; // private
```

### Validation

The `AlphaDashDot` and `SemanticVersion` validation rules now inherit from `BaseValidationRule`, in
`\Aedart\Validation\Rules`. If you are extending these validation rules, then you may have to adapt your code.

Additionally, if you have validation rules that inherit from `\Aedart\Validation\Rules\BaseRule` (_removed_), then you
must upgrade them to inherit from the new `BaseValidationRule`.

**_:x: previously_**

```php
use Aedart\Validation\Rules\BaseRule;

class MyValidationRule extends BaseRule
{
    // ...not shown...
}
```

**_:heavy_check_mark: Now_**

```php
use Aedart\Validation\Rules\BaseValidationRule;

class MyValidationRule extends BaseValidationRule
{
    // ...not shown...
}
```

See the source code and [Laravel Validation Rules](https://laravel.com/docs/11.x/validation#custom-validation-rules) for additional information.

### Trait Tester

The `TraitTester` in `\Aedart\Testing\Helpers` has been reworked to use [`Mockery`](https://github.com/mockery/mockery),
instead of the previous trait testing utilities offered by PHPUnit.
This change should not affect you, unless you are extending / overwriting this testing utility. 

### Password Rehashing Action

Automatic password rehashing has become a default part of Laravel, since version `v11.x`
(_see [Laravel documentation](https://laravel.com/docs/11.x/releases#automatic-password-rehashing) for details_).
For this reason, the `RehashPasswordIfNeeded` action and `PasswordWasRehashed`, in `\Aedart\Auth\Fortify`, have been
deprecated and will be removed in the next major version.

### Random Int

The `Math::randomInt`, in `\Aedart\Utils`, has been deprecated. Please use `Math::randomizer()->int()` instead.

### Removed Deprecated Components

Several deprecated components have been removed. Please review the `CHANGELOG.md` for details.

## Onward

More extensive details can be found in the [changelog](https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md).
