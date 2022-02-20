---
description: How to export Dto
---

# Export

The `Dto` abstraction supports two main data export methods; to array and [JSON](./json.md).

## Array

Each DTO can be exported to an array.

```php 
$properties = $person->toArray();
var_dump($properties);  
```

The above example will output the following:

```shell
array(2) {
  ["name"]=> string(5) "Timmy"
  ["age"]=> int(19)
}
```
