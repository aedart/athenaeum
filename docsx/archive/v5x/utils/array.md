---
description: About the Array Utility
sidebarDepth: 0
---

# Array

Extended version of Laravel's [`Arr` component](https://laravel.com/docs/8.x/helpers#arrays).

## `randomElement()`

Returns a single random element from a given list.

```php
use Aedart\Utils\Arr;

$element = Arr::randomElement(['Jim', 'Sine', 'Ally', 'Gordon']);
```

See also Laravel's [`Arr::random`](https://laravel.com/docs/8.x/helpers#method-array-random).

### Seed

You can also provide a [seed for the random number generator](https://www.php.net/manual/en/function.mt-srand.php). 

```php
use Aedart\Utils\Arr;
use Aedart\Utils\Math;

$element = Arr::randomElement(['Jim', 'Sine', 'Ally', 'Gordon'], Math::seed());
```

See [`Math::seed()`](math.md) for additional information about seeding.
