---
description: Dto Serialization
---

# Serialization

You can also [serialise](https://www.php.net/manual/en/function.serialize) and [unserialise](https://www.php.net/manual/en/function.unserialize.php) your DTOs, using PHP's native methods.

## Serialise

```php
$serialised = serialize($person);
```

## Unserialise

```php
$person = unserialize($serialised);
```
