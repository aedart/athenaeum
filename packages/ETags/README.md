# Athenaeum ETags

Provides a "profile" based approach to generate [ETags](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/ETag) of content, in your Laravel application.
The default provided implementation is able to generate ETags for [weak and strong comparisons](https://httpwg.org/specs/rfc9110.html#entity.tag.comparison).

```php
use Aedart\ETags\Facades\Generator;

// Generate an ETag for strong comparison, of content
$eTag = Generator::makeStrong($content);

echo (string) $eTag; // "4720b076892bb2fb65e75af902273c73a2967e4a"
```

Or to generate ETags that are flagged as "weak" (_for weak comparison_)

```php
$eTag = Generator::makeWeak($content);

echo (string) $eTag; // W/"0815"
```

## Parsing

When you wish to create an `ETag` instance, e.g. from a Http request header, then you can achieve this in the following way:

```php
use Aedart\ETags\Facades\Generator;

$eTag = Generator::parseSingle($request->header('If-None-Match')); // E.g. W/"0815"

echo $eTag->raw(); // E.g. 0815
echo $eTag->isWeak(); // true
```

## Matching

Lastly, ETags can also be matched against each other, in accordance with [RFC9110](https://httpwg.org/specs/rfc9110.html#rfc.section.8.8.3.2).

```php
$eTagA = Generator::parse('W/"0815"');
$eTagB = Generator::parse('W/"0815"');

echo $eTagA->matches($eTagB, true); // false - strong comparison
echo $eTagA->matches($eTagB); // true - weak comparison
```

## Official Documentation

Please read the [official documentation](https://aedart.github.io/athenaeum/) for additional information.

The mono repository is located at [github.com/aedart/athenaeum](https://github.com/aedart/athenaeum)

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
