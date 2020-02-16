---
description: About the Array Utility
sidebarDepth: 0
---

# Array

Extended version of Laravel's [`Arr` component](https://laravel.com/docs/6.x/helpers#arrays).

## `randomElement()`

Returns a single random element from a given list.

```php
use Aedart\Utils\Arr;

$element = Arr::randomElement(['Jim', 'Sine', 'Ally', 'Gordon']);
```

See also Laravel's [`Arr::random`](https://laravel.com/docs/6.x/helpers#method-array-random).

### Shuffle & Seed

You can instruct the method to [shuffle](https://en.wikipedia.org/wiki/Shuffling) the given list before picking a random element.
Furthermore, you can also provide it with a seed.

```php
use Aedart\Utils\Arr;
use Aedart\Utils\Math;

$element = Arr::randomElement(['Jim', 'Sine', 'Ally', 'Gordon'], true, Math::seed());
```

See [`Math::seed()`](math.md) for additional information about seeding.
