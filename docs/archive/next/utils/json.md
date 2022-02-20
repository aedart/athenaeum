---
description: About Json Encoding and Decoding Helper
sidebarDepth: 0
---

# Json

The `Json` component offers a few [JSON](https://www.json.org/) utilities.
It uses PHP's native [`json_encode()`](https://secure.php.net/manual/en/function.json-encode.php) and [`json_decode()`](https://secure.php.net/manual/en/function.json-decode.php).

## Encoding and Decoding

The `encode()` and `decode()` methods will automatically throw a [`\JsonException `](http://php.net/manual/en/class.jsonexception.php), if encoding or decoding fails.
It does so by setting the [`JSON_THROW_ON_ERROR`](http://php.net/manual/en/json.constants.php) bitmask option, when invoked.

```php
use Aedart\Utils\Json;

$encoded = Json::encode([
    'name'  => 'Reilly',
    'age'   => 32
]);

// ------------------------------------------ //

$decoded = Json::decode('{"name":"Michele Rodriguez","age":4}');
```
