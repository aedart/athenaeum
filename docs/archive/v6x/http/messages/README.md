---
description: About the Http Messages Package
sidebarDepth: 0
---

# Http Messages

Offers a few [PSR-7 Http Message](https://www.php-fig.org/psr/psr-7/) utilities.

## Request/Response Serializer Example

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
