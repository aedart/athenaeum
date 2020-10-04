# Athenaeum Http Messages

This package offers a few [PSR-7 Http Message](https://www.php-fig.org/psr/psr-7/) utilities.

## Example

Amongst the utilities are request and response serializers, able to serialize a to `string` or `array`.

```php
$factory = $this->getHttpSerializerFactory();
$serializer = $factory->make($response);

echo (string) $serializer;

// Example Output:
//
//  HTTP/1.1 201 Created
//  Content-Type: application/json
//  
//  {"id":458712,"name":"Sven Jr.","age":27}
```

## Documentation

Please read the [official documentation](https://aedart.github.io/athenaeum/) for additional information.

## Repository

The mono repository is located at [github.com/aedart/athenaeum](https://github.com/aedart/athenaeum)

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
