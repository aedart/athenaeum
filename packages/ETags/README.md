# Athenaeum ETags

Provides a "profile" based approach to generate [ETags](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/ETag) of content, in your Laravel application.
The default provided implementation is able to generate ETags for [weak and strong comparisons](https://httpwg.org/specs/rfc9110.html#entity.tag.comparison).

```php
use Aedart\ETags\Facades\Generator;

// Generate an ETag for strong comparison, of content
$etag = Generator::makeStrong($content);

echo (string) $etag; // "4720b076892bb2fb65e75af902273c73a2967e4a"
```

Or to generate ETags that are flagged as "weak" (_for weak comparison_)

```php
$etag = Generator::makeWeak($content);

echo (string) $etag; // W/"0815"
```

## Parsing

To parse ETags from Http headers, you can use the `parse()` method. It returns a collection of `ETag` instances.

```php
// E.g. If-None-Match: W/"0815", W/"0816", W/"0817"
$collection = Generator::parse($request->header('If-None-Match'));  

foreach ($collection as $etag) {
    echo (string) $etag;
}
```

## Compare

Lastly, ETags can also be matched against each other, in accordance with [RFC9110](https://httpwg.org/specs/rfc9110.html#rfc.section.8.8.3.2).

#### Using Collection

```php
// Etags from Http Header
$collection = Generator::parse($request->header('If-Match')); // E.g. 'W/"0815"' 

// Other Etag for your resource
$etag = Generator::makeWeak($content); // E.g. W/"0815"

// Compare etags against resource's etag
echo $collection->contains($etag, true); // false - strong comparison
echo $collection->contains($etag);       // true - weak comparison
```

#### Using Etag instance

You can also compare individual `ETag` instances, using the `matches()` method.

```php
$etagA = Generator::parseSingle('W/"0815"');
$etagB = Generator::parseSingle('W/"0815"');

echo $etagA->matches($etagB, true); // false - strong comparison
echo $etagA->matches($etagB);       // true - weak comparison
```

## Official Documentation

Please read the [official documentation](https://aedart.github.io/athenaeum/) for additional information.

The mono repository is located at [github.com/aedart/athenaeum](https://github.com/aedart/athenaeum)

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
