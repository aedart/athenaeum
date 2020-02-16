---
description: About the Math Utility
sidebarDepth: 0
---

# Math

Offers a few math related utility methods.

## `randomInt()`

Generates a random number between given minimum and maximum values.

```php
use Aedart\Utils\Math;

$value = Math::randomInt(1, 10);
```

## `seed()`

Generates a value that can be used for seeding the random number generator.

```php
use Aedart\Utils\Math;

$seed = Math::seed();

mt_srand($seed);
```
