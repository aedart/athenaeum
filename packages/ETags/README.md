# Athenaeum ETags

This package provides a "profile" based approach to generate [ETags](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/ETag), and an evaluator to deal with [Http Conditional Requests](https://developer.mozilla.org/en-US/docs/Web/HTTP/Conditional_requests), for your Laravel application.


## ETags Examples

### Generate

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

### Parsing

To parse ETags from Http headers, you can use the `parse()` method. It returns a collection of `ETag` instances.

```php
// E.g. If-None-Match: W/"0815", W/"0816", W/"0817"
$collection = Generator::parse($request->header('If-None-Match'));  

foreach ($collection as $etag) {
    echo (string) $etag;
}
```

### Compare

ETags can also be matched against each other, in accordance with [RFC9110](https://httpwg.org/specs/rfc9110.html#rfc.section.8.8.3.2).

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

## Evaluate Http Preconditions Examples

The `Evaluator` component is able to process the incoming request against all the defined [RFC9110 preconditions](https://httpwg.org/specs/rfc9110.html#preconditions), in accordance with specified [evaluation precedence](https://httpwg.org/specs/rfc9110.html#precedence).
Depending on the precondition requested, if it passes or fails, the request can either proceed or it will be aborted using customisable Http Exceptions.
Your Laravel application should do the rest, whenever the request is aborted.

```php
use Aedart\ETags\Preconditions\Evaluator;
use Aedart\ETags\Preconditions\Resources\GenericResource;

// Process If-Match, If-None-Match, If-Modified-Since... etc
// Depending on condition's pass/fail, the request can be aborted via
// an appropriate Http Exception, or proceed to your logic...
$resource = Evaluator::make($request)
    ->evaluate(new GenericResource(
        data: $model,
        etag: $model->getStrongEtag(),
        lastModifiedDate: $model->updated_at
    ));
```

To summarise, the following preconditions are supported:

* [If-Match](https://httpwg.org/specs/rfc9110.html#field.if-match)
* [If-None-Match](https://httpwg.org/specs/rfc9110.html#field.if-none-match)
* [If-Modified-Since](https://httpwg.org/specs/rfc9110.html#field.if-modified-since)
* [If-Unmodified-Since](https://httpwg.org/specs/rfc9110.html#field.if-unmodified-since)
* [If-Range](https://httpwg.org/specs/rfc9110.html#field.if-range)

The `Evaluator` also supports adding your own custom preconditions to be evaluated, should you need such.

## Official Documentation

Please read the [official documentation](https://aedart.github.io/athenaeum/) for additional information.

The mono repository is located at [github.com/aedart/athenaeum](https://github.com/aedart/athenaeum)

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
