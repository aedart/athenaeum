---
description: Export Dto to json
---

# Json

All DTOs inherit from [`JsonSerializable`](http://php.net/manual/en/class.jsonserializable.php).
This means that when using `json_encode()`, the DTO automatically ensures that its properties are serializable by the encoding method.

## Encoding

### Via `json_encode()`

```php
$person = new Person([
    'name' => 'Rian Dou',
    'age' => 29
]);

echo json_encode($person);
```

The above example will output the following Json string;

``` json
{
    "name":"Rian Dou",
    "age":29
}
```

### Via `toJson()`

You can also perform json serialization directly on the DTO, by invoking the `toJson()` method.

```php
$person = new Person([
    'name' => 'Rian Dou',
    'age' => 29
]);

echo $person->toJson(); // The same as invoking json_encode($person);
```

## Populate from Json

To populate a DTO directly from a Json string, use the `fromJson()` method.

``` php
$json = '{"name":"Miss Mossie Wehner Sr.","age":28}';

$person = Person::fromJson($json);

echo $person->name; // Miss Mossie Wehner Sr.
```

::: tip Note
`fromJson()` returns a new DTO instance.
:::
