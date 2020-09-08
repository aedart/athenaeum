---
description: Condition Callbacks
sidebarDepth: 0
---

# Conditions

Inspired heavily by Laravel's [Collections](https://laravel.com/docs/7.x/collections#method-when), the `when()` and `unless()` methods give you the possibility to invoke callbacks, when a condition evaluates to `true`. 

[[TOC]]

## When

`when()` invokes a callback, if it's first argument evaluates to `true`. 

```php
use Aedart\Contracts\Http\Clients\Requests\Builder;

$builder = $client
        ->when(true, function(Builder $builder){
            $builder->where('name', 'john');
        });
```

If the first argument evaluate to `false`, then the method will invoke it's "otherwise" callback, if one is provided.

```php
use Aedart\Contracts\Http\Clients\Requests\Builder;

$builder = $client
        ->when(false, function(Builder $builder){
            // Not invoked...
            $builder->where('name', 'John');
        }, function(Builder $builder){
            // Invoked...
            $builder->where('name', 'Simon');
        });
```

## Unless

The inverse method, `unless()`, will invoke it's callback if the first argument is not `true`.

```php
use Aedart\Contracts\Http\Clients\Requests\Builder;

$builder = $client
        ->unless(false, function(Builder $builder){
            $builder->where('name', 'john');
        });
```

Consequently, if the first argument is `true`, then it's "otherwise" callback is invoked, when provided.

```php
use Aedart\Contracts\Http\Clients\Requests\Builder;

$builder = $client
        ->unless(true, function(Builder $builder){
            // Not invoked...
            $builder->where('name', 'John');
        }, function(Builder $builder){
            // Invoked...
            $builder->where('name', 'Simon');
        });
```
