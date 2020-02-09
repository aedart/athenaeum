# Json

The `\Aedart\Utils\Json` component offers a few [JSON](https://www.json.org/) utilities.
Among such, it wraps PHP's native [`json_encode()`](https://secure.php.net/manual/en/function.json-encode.php) and [`json_decode()`](https://secure.php.net/manual/en/function.json-decode.php).

## Encoding and Decoding

Using the `encode()` and `decode()` methods, you ensure that if encoding fails, a `JsonEncodingException` will be thrown.

```php
use Aedart\Utils\Json;

$encoded = Json::encode([
    'name'  => 'Reilly',
    'age'   => 32
]);

// ------------------------------------------ //

$decoded = Json::decode('{"name":"Michele Rodriguez","age":4}');
```

::: tip Note
From PHP 7.3, `json_encode()` and `json_decode()` will natively support an option to throw an exception upon encoding errors.
These wrapper methods will be adapted to use this native option in the future.
:::
