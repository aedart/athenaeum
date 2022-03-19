---
description: Athenaeum Release Notes
---

# Release Notes

[[toc]]

## Support Policy

Athenaeum attempts to follow a release cycle that matches closely to that of [Laravel](https://laravel.com/docs/9.x/releases).
However, due to limited amount of project maintainers, no guarantees can be provided. 

| Version | PHP         | Laravel | Release                    | Security Fixes Until |
|---------|-------------|---------|----------------------------|----------------------|
| `7.x`   | _`8.1`_     | _TBD_   | _TBD_                      | _TBD_                |
| `6.x`*  | `8.0 - 8.1` | `v9.x`  | _Scheduled for March 2022_ | February 2023        |
| `5.x`   | `7.4`       | `v8.x`  | October 4th, 2020          | N/A                  |
| `4.x`   | `7.4`       | `v7.x`  | April 15th, 2020           | N/A                  |
| `< 4.x` | _-_         | _-_     | _See `CHANGELOG.md`_       | N/A                  |

*: _current supported version._

_TBD: "To be decided"._

## `v6.x` Highlights

These are some the new features of Athenaeum `v6.x`.

### PHP `v8` and Laravel `v9.x`

Athenaeum has been upgraded to usePHP `v8.0` and [Laravel `v9.x`](https://laravel.com/docs/9.x/releases).
Furthermore, PHP `v8.1` is also supported.

### Improved Documentation

Several improvements have been made throughout the documentation.
From version `6.x`, a [Security Policy](./security.md), [Code of Conduct](./code-of-conduct.md) and an improved [Contribution Guide](./contribution-guide.md) is made available.

### Union Types support in DTO

The `Dto` and `ArrayDto` now support [union types](https://php.watch/versions/8.0/union-types) for their properties.
When populating a DTO, the most suitable match will bre chosen.

```php
class Person extends ArrayDto
{
    protected array $allowed = [
        'name' => 'string|null',
    ];
}

class Organisation extends Dto
{
    protected array $allowed = [
        'name' => 'string|null',
        'slogan' => 'string|null',
    ];
}

class Record extends Dto
{    
    protected array $allowed = [
        'reference' => ['string', Person::class, Organisation::class, 'null'],
    ];
}

// ------------------------------------------------------------------------ //

// Reference is a string...
$record->populate([
    'reference' => 'https:://google.com'
]);
echo gettype($record->reference); // string

// Reference becomes a Person...
$record->populate([
    'reference' => [ 'name' => 'Jane Jensen' ]
]);
echo ($record->reference instanceof Person); // true

// Reference becomes an Organisation...
$record->populate([
    'reference' => [ 'name' => 'Acme', 'slogan' => 'Building stuff...' ]
]);
echo ($record->reference instanceof Organisation); // true
```

See [Union Type Handling documentation](./dto/nested-dto.md#union-types) for additional examples.

### MIME-types detection

The [MIME-types](./mime-types) packages offers a way to detect a file's MIME-type based on a small sample of its contents.

```php
use Aedart\MimeTypes\Detector;

$file = fopen('my-picture.jpg', 'rb');
$mimeType = (new Detector())->detect($file);
```

### Maintenance Modes

A new [Maintenance Modes](./maintenance/modes) package has been added, which offers a few additional drivers that can be used for [storing application down](https://laravel.com/docs/9.x/configuration#maintenance-mode) state.

### Where not in slug...

The `\Aedart\Database\Models\Concerns\Slugs` concern now offers a `whereSlugNotIn()` [query scope](https://laravel.com/docs/9.x/eloquent#local-scopes) method.

```php
// ...inside your Eloquent model

$result = $query
    ->whereSlugNotIn(['alpha', 'beta', 'gamma'])
    ->get();
```

### Validate JSON

The `Json` utility has been given a new method, which can be used to determine if a value is a valid JSON encoded string.

```php
use Aedart\Utils\Json;

echo Json::isValid('{ "name": "Sven" }'); // true
```

### Purpose change of Core Application

Perhaps a less important highlight, but still worth mentioning, is that the purpose of the [Core Application package](./core) has changed from Athenaeum `v6.x`.
The Core Application package was originally developed to act as a "bridge" for integrating Laravel components and services into legacy applications.
This is no longer the case. Version `6.x` requires a minimum of PHP `v8.0` and it does not feel right to presume that the Core Application can be used as originally intended (_see original motivation in [version `v4.x`](../v4x/core)_). 

From version `6.x`, the Core Application is intended for the following purposes:

* Testing
* Tinkering
* Development of **non-essential** standalone applications

If you are using the Core Application, for its original intent, then you are **strongly encouraged** to consider redesigning your application, e.g. rewrite your application using [Laravel](https://laravel.com/) or other appropriate framework.  

## Changelog

Make sure to read the [changelog](https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md) for additional information about the latest release, new features, changes and bug fixes. 
