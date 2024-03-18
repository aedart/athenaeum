---
description: Obtain the underlying raw resource
sidebarDepth: 0
---

# Raw Resource

To obtain the raw underlying resource, there are two methods you should know about.

[[TOC]]

## `resource()`

For situations when you require the underlying `resource` of a stream instance, you can use the `resource()` method.
It returns the underlying resource directly, without detaching it from the stream instance.

```php
$stream = FileStream::open('people.txt', 'r');
$resource = $stream->resource();
```

::: warning

The `resource()` method exists for special cases, e.g. to manipulate of access the resource in ways that are not offered by this package's stream components.
What you choose to do with the underlying resource, falls outside the scope of the stream instance.
Please be very careful...

**Recommendation**

The `detach()` method is the preferred and RECOMMENDED way of obtaining the underlying resource, should you require direct access to it.

**Alternative**

Consider extending the `Stream` or `FileStream` component and implement desired functionality, rather than manipulating underlying resource outside the scope of the stream instance.

:::

## `detach()`

The `detach()` method is considered to be the safest approach to obtaining the underlying resource.
Please see [method description](./open-close.md#detaching-resource) for documentation.
