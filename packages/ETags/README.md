# Athenaeum ETags

Provides "profile" based [ETag](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/ETag) generators that
allow you to create hash values of content, for your Http responses.

```php
use Illuminate\Http\Request;
use Aedart\ETags\Facades\Generator;

class UsersController
{
    public function show(Request $request){
        // ...obtain a record - not shown...
        
        // Generate an Etag for record
        $eTag = Generator::make($record);
        
        return response()
            ->withEtag($eTag);
    }
}
```

When you wish to create an `ETag` instance, e.g. from a Http request header, then you can achieve this in the following way:

```php
use Aedart\ETags\Facades\Generator;

$eTag = Generator::parse($request->header('etag')); // E.g. W/"0815"

echo $eTag->raw(); // E.g. 0815
echo $eTag->isWeak(); // true
```

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
