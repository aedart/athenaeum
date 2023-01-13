---
description: Apply Request Criteria
sidebarDepth: 0
---

# Criteria

Within this context, criteria (_or criterion_) is the equivalent to Laravel's [Query Scope](https://laravel.com/docs/9.x/eloquent#query-scopes).
It allows you to add additional constraints, scopes, attachments, cookies, expectations or http query parameters, whilst isolating it in a separate class.  

[[TOC]]

## Create Criteria

To create a criteria, inherit from the `Criteria` interface and implement the `apply()` method.

```php
<?php

namespace Acma\Http\Query\Criteria;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Clients\Requests\Criteria;

class LowPrice implements Criteria
{
    public function apply(Builder $request) : void
    {
        $request
            ->where('price', 'lt', 1500)
            ->where('currency', 'DKK');
    }
}
```

## Apply Criteria

Use the `applyCriteria()` method to add your custom criteria to the request builder.

```php
use Acma\Http\Query\Criteria\LowPrice;

$response = $client
        ->applyCriteria(new LowPrice())
        ->get('/rental-cars');
```

The method also accepts an array of criteria.

```php
$response = $client
        ->applyCriteria([
            new LowPrice(),
            new RentalPeriod('+2 week'),
            new HybridFuel()
        ])
        ->get('/rental-cars');
```
