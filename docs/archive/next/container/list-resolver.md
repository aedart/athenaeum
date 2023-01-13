---
description: About the List Resolver
---

# List Resolver

In situations when you need to resolve a list of instances, e.g. a list of filters, the `ListResolver` component can help you out.

[[toc]]

## Prerequisite
   
Laravel's Service `Container` must be available in your application.

## Example

```php
use Aedart\Container\ListResolver;

$list = [
    \Acme\Filters\SanitizeInput::class,
    \Acme\Filters\ConvertEmptyToNull::class,
    \Acme\Filters\ApplySorting::class
];

// Resolve list of dependencies
$filters = (new ListResolver())->make($list);
```

Behind the scene, the [`make()`](https://laravel.com/docs/9.x/container#the-make-method) method is used to resolve the list of dependencies.
This means that even if your components have nested dependencies, then these too will be resolved.  

## Arguments

To provide arguments for a dependency, you can use an array of key-value pairs.
Consider the following:

```php
use Aedart\Container\ListResolver;

$list = [
    \Acme\Filters\SanitizeInput::class,
    \Acme\Filters\ConvertEmptyToNull::class,
    \Acme\Filters\ApplySorting::class => [
        'sortBy' => 'age',
        'direction' => 'desc'
    ]
];

// Resolve list of dependencies
$filters = (new ListResolver())->make($list);
```

In the above example, the `ApplySorting` component will be instantiated with two arguments; `sortBy` and `direction`.

## Apply Callback

You may also provide a custom callback to be invoked, for each resolved instance.
This can be done so via the `with()` method.

```php
use Aedart\Container\ListResolver;

$list = [
    \Acme\Filters\SanitizeInput::class,
    \Acme\Filters\ConvertEmptyToNull::class,
    \Acme\Filters\ApplySorting::class
];

// Resolve list of dependencies
$filters = (new ListResolver())
        ->with(function($filter){
            $filter->setRequest($_GET);

            return $filter;
        })
        ->make($list);
```

::: warning Caution
The callback *MUST* return a resolved instance.
:::

## Use Custom `Container`

If you wish to use a custom Service `Container`, then you can simply provide your custom instance as the constructor's argument.

```php
use Aedart\Container\ListResolver;
use Acme\IoC\Container;

$resolver = new ListResolver(new Container());
```


