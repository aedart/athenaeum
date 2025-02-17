---
description: How to work with ETags
sidebarDepth: 0
---

# How to use

A `factory` is responsible for generating `ETag` instances, and parsing of Http header values. 

[[TOC]]

## Obtain Factory

To obtain the `Factory` instance, use the `ETagGeneratorFactoryTrait` in your components.

```php
use Aedart\ETags\Traits\ETagGeneratorFactoryTrait;

class UsersController
{
    use ETagGeneratorFactoryTrait;
    
    public function index()
    {
        $factory = $this->getEtagGeneratorFactory();
        
        // ..remaining not shown...
    }
}
```

## Generator

Before you are able to create a new `ETag` instance, you must first obtain a `Generator`.
This can be done via the `profile()` method in the `Factory`.

```php
$generator = $factory->profile(); // Default profile
```

To obtain a `Generator` for a different profile, simply specify the profile's name as argument.

```php
$generator = $factory->profile('my-custom-profile');
```

For more information, see [Generator documentation](./generators/README.md).

## Make an Etag

Once you have your desired Etag `Generator` instance, use the `make()` method to create a new `ETag` instance of some content.
The method accepts two arguments:

* `$content`: `mixed` : _arbitrary content_
* `$weak` : `bool` : _optional, default `true`_

::: tip Weak vs. Strong
If `$weak` is set to true, the created `ETag` is flagged as "weak" and therefore indented to be used for "weak comparison" (_E.g. `If-None-Match` Http header comparison_).

Otherwise, when `$weak` is set to false, the `ETag` is not flagged as "weak". Thus, the etag is then intended to be used for "strong comparison" (_E.g. `If-Match` Http header comparison_).

For additional information, see [RFC9110](https://httpwg.org/specs/rfc9110.html#entity.tag.comparison).
:::

```php
$etag = $generator->make('my-content', true);

echo (string) $etag; // E.g. W/"ab416j5"
```

For the sake of convenience, you can use the shortcut methods `makeWeak()` and `makeStrong()` to achieve the same.

```php
$weakEtag = $generator->makeWeak('my-content');
$strongEtag = $generator->makeStrong('my-content');

echo (string) $weakEtag; // E.g. W/"ab416j5"
echo (string) $strongEtag; // E.g. "4720b076892bb2fb65e75af902273c73a2967e4a"
```

## Using Facade

This package also comes with a [Facade](https://laravel.com/docs/11.x/facades), that allows you to achieve the same as previously shown.

### Create new Etags

To make new etags, simply invoke the `make()`, `makeWeak()` or `makeStrong()` methods on the facade.

```php
use Aedart\ETags\Facades\Generator;

$weakEtag = Generator::makeWeak('my-content');
$strongEtag = Generator::makeStrong('my-content');
```

### Use different profile

Unless otherwise specified, the "default" generator "profile" is used by the facade, when creating new etag instances.
To use a different profile, specify the desired name via the `profile()` method.

```php
$etag = Generator::profile('my-custom-profile')->make('my-content');
```

## Parsing

When you need to create ETag instance from string values, e.g. Http headers, then you can use the `parse()` method, in the `Factory`.
The method will attempt to parse given etag values and create a collection with corresponding `ETag` instances.

```php
// Via the factory
$collection = $factory->parse('W/"15487", W/"r2d23574", W/"c3pio784"');

// ...Or via the Facade
$collection = Generator::parse('W/"15487", W/"r2d23574", W/"c3pio784"');
```

If you only desire to parse a single value, then use the `parseSingle()` which will return a single `ETag` instance.

```php
// Via the factory
$etag = $factory->parseSingle('W/"15487"');

// ...Or via the Facade
$etag = Generator::parseSingle('W/"15487"');
```

::: warning Caution
Both `parse()` and `parseSingle()` will throw an `ETagException`, if unable to parse given string value.

For instance, if you try to parse a list of value that contain a wildcard (`*`), then it is considered syntactically invalid (_acc. to RFC9110_).
An exception will therefore be thrown.

```php
// Throws exception ... invalid list of etag values!
$collection = Generator::parse('*, W/"r2d23574", W/"c3pio784"');

$etag = Generator::parseSingle('my-invalid-etag-value');

// ---------------------------------------------------------------- //

// Valid
$collection = Generator::parse('*');

// ...Or parse single
$etag = Generator::parseSingle('*');
echo $etag->isWildcard(); // true
```

:::

## Comparison

You have the following two comparison options, when you want to compare etags:

* **strong comparison**: _two entity tags are equivalent if both are not weak and their opaque-tags match character-by-character (source [RFC-9110]((https://httpwg.org/specs/rfc9110.html#rfc.section.8.8.3.2)))._
* **weak comparison**: _two entity tags are equivalent if their opaque-tags match character-by-character, regardless of either or both being tagged as "weak" (source [RFC-9110]((https://httpwg.org/specs/rfc9110.html#rfc.section.8.8.3.2)))._

Please read RFC-9110's description of [`If-Match`](https://httpwg.org/specs/rfc9110.html#field.if-match),
[`If-None-Match`](https://httpwg.org/specs/rfc9110.html#field.if-none-match) Http headers,
and [how the comparison works](https://httpwg.org/specs/rfc9110.html#rfc.section.8.8.3.2)
to understand the difference and when to use either of the comparison methods.

::: tip Strong vs. Weak Comparison
_The herein shown examples do not necessarily represent correct usage of the comparison for http headers._
_To clarify when to use "weak" or "strong" comparison, consider the following:_

`If-Match`: _"[...] An origin server MUST use the **strong comparison** function when comparing entity tags for If-Match [...]" (source [RFC-9110](https://httpwg.org/specs/rfc9110.html#field.if-match))_

`If-None-Match`: _"[...] A recipient MUST use the **weak comparison** function when comparing entity tags for If-None-Match [...]" (source [RFC-9110](https://httpwg.org/specs/rfc9110.html#field.if-none-match))_

:::

### Via Collection

When you have a collection of etag instances, you can match a single `ETag` (_or value_) against the etags in the collection.
The `contains()` method allows you to do so.

```php
$collection = Generator::parse('W/"15487", W/"r2d23574", W/"c3pio784"');

$etag = Generator::makeWeak($content); // E.g. W/"c3pio784"

echo $collection->contains($etag, true); // false - strong comparison
echo $collection->contains($etag);       // true - weak comparison
```

You may also compare against a string etag value directly.

```php
echo $collection->contains('W/"c3pio784"', true); // false - strong comparison
echo $collection->contains('W/"c3pio784"');       // true - weak comparison
```

### Via ETag

To compare two `ETag` instances against each other, use the `matches()` method.

```php
$etagA = Generator::parseSingle('W/"r2d23574"');
$etagB = Generator::makeWeak($content); // E.g. W/"r2d23574"

echo $etagA->matches($etagB, true); // false - strong comparison
echo $etagA->matches($etagB);       // true - weak comparison
```

### Wildcard

A wildcard (`*`) is a valid etag value for both [`If-Match`](https://httpwg.org/specs/rfc9110.html#field.if-match)
and [`If-None-Match`](https://httpwg.org/specs/rfc9110.html#field.if-none-match) Http headers.
When comparing against a wildcard, the result will always be `true` if you have an `ETag` or etag value to compare against, regardless whether you use "weak" or "strong" comparison.

```php
$collection = Generator::parse('*');

echo $collection->contains('W/"c3pio784"', true); // true - strong comparison
echo $collection->contains('W/"c3pio784"');       // true - weak comparison

// -------------------------------------------------------------------------- //

$etagA = Generator::parseSingle('*');
$etagB = Generator::makeWeak($content); // E.g. W/"15487"

echo $collection->contains($etag, true); // true - strong comparison
echo $collection->contains($etag);       // true - weak comparison
```