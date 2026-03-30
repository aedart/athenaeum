---
description: Stream meta
sidebarDepth: 0
---

# Meta

Whenever a stream component is created, a new meta `Repository` is assigned to it. It contains various values obtained by PHP's [`stream_get_meta_data()`](https://www.php.net/manual/en/function.stream-get-meta-data) and [`fstat()`](https://www.php.net/manual/en/function.fstat).
The meta repository can also be used to assign arbitrary data or information to a stream, which can be useful in situations when working with multiple streams at the same time and require some additional information to be associated with each.

```php
$stream = FileStream::open('people.txt', 'rb');

$meta = $stream->meta();

echo $meta->get('stats.size'); // 12
```

::: tip Raw meta always merged
The "raw" meta-data that is provided by `rawMeta()` (_see method description below_). This data is _ALWAYS_ merged into the meta `Repository` instance, whenever you invoke the `meta()` method.
:::

## Raw Meta

Each stream instance comes with the ability to obtain the underlying resource's "meta-data", using PHP's [`stream_get_meta_data()`](https://www.php.net/manual/en/function.stream-get-meta-data) and [`fstat()`](https://www.php.net/manual/en/function.fstat) methods.

To acquire a raw version of this meta-data, use the `rawMeta()` method.

```php
$stream = FileStream::open('people.txt', 'rb');

$rawMeta = $stream->rawMeta(); // array
```

**Note** _As previously mentioned, this method is always invoked and its output is automatically merged into the meta `Repository`, whenever the `meta()` method is called!_

## Assign Arbitrary Meta-Data

To assign arbitrary meta-data to a stream, use the `setMetaRepository()`.
The method can accept the following types as argument:

* `array`: associate array, containing key-value pairs.
* `\Aedart\Contracts\Streams\Meta\Repository`: A meta `Repository` instance.
* `null`: If null is given, then a new meta `Repository` instance will automatically be set.

```php
$stream = FileStream::open('people.txt', 'rb')
    ->setMetaRepository([
        'acme.foo' => 'bar'
    ]);

$meta = $stream->meta();

echo $meta->get('acme.foo'); // bar
```

### Alternative

Alternatively, you may also specify custom arbitrary data directly in the meta `Repository`, using it's `set()` method.  

```php
$stream->meta()->set('acme.bar', 'foo');
echo $stream->meta()->get('acme.bar'); // foo
```

::: warning Caution
You _SHOULD_ always prefix your arbitrary meta-data keys, to avoid accidental naming conflicts and overwrites with values provided by `rawMeta()`.
:::
