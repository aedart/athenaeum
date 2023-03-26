# Json

The `\Aedart\Utils\Json` component offers a few [JSON](https://www.json.org/) utilities.
Among such, it wraps PHP's native [`json_encode()`](https://secure.php.net/manual/en/function.json-encode.php) and [`json_decode()`](https://secure.php.net/manual/en/function.json-decode.php).

## Encoding and Decoding

Using the `encode()` and `decode()` methods, you ensure that the [`JSON_THROW_ON_ERROR`](http://php.net/manual/en/json.constants.php) bitmask option is automatically set.
This means that encoding or decoding should fail, the native [`\JsonException `](http://php.net/manual/en/class.jsonexception.php) is thrown.

```php
use Aedart\Utils\Json;

$encoded = Json::encode([
    'name'  => 'Reilly',
    'age'   => 32
]);

// ------------------------------------------ //

$decoded = Json::decode('{"name":"Michele Rodriguez","age":4}');
```
