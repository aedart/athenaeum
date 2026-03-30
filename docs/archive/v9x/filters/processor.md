---
description: Http Query Parameter Processors
---

# Processor

A http query parameter processor is responsible for creating appropriate query filters, based on its assigned parameter value.

[[TOC]]

## How it works

A query parameter is assigned to the processor. It is then responsible for validating the value of that parameter and create one or more query filters, which are stored inside a `BuiltFiltersMap` component.

The processor is invoked by a [builder](./builder.md), if a http query parameter is matched.

## How to create processor

You can create a new processor by extending the `BaseProcessor` abstraction.

```php
use Aedart\Filters\BaseProcessor;
use Aedart\Contracts\Filters\BuiltFiltersMap;
use Acme\Models\Filters\SearchFilter;

class SimpleSearchProcessor extends BaseProcessor
{
    public function process(BuiltFiltersMap $built, callable $next)
    {
        // E.g. skip if parameter was submitted with empty value...
        $value = $this->value();
        if (empty($value)) {
            return $next($built);
        }
        
        // Create and assign your query filter
        $filter = new SearchFilter($value);
        $built->add($this->parameter(), $filter);
        
        // Finally, process the next processor
        return $next($built);
    }
}
```

In the above shown example, a search filter instance is created and added to the "built filters map" - a data transfer object, which is passed through each processor.
Laravel's [pipeline](https://packagist.org/packages/illuminate/pipeline) is used behind the scene, for invoking the `process()` method.

## Validation

A received query parameter might contain incorrect or harmful value. You are therefore highly encouraged to validate the received input, before using it in a query filter.
The following example shows a possible way to perform validation of a parameter's value.

```php
use Aedart\Filters\Exceptions\InvalidParameter;

class SimpleSearchProcessor extends BaseProcessor
{
    public function process(BuiltFiltersMap $built, callable $next)
    {
        // Fail if parameter's value is invalid...
        $value = $this->value();
        if (empty($value)) {
            throw InvalidParameter::make($this, 'Empty value is not allowed');
        }
        
        // Create and assign your query filter
        $filter = new SearchFilter($value);
        $built->add($this->parameter(), $filter);
        
        // Finally, process the next processor
        return $next($built);
    }
}
```

The [builder](./builder.md) that runs your processor will automatically handle any exceptions that inherit from `InvalidParameterException`¹.
Exceptions, of the mentioned kind, will be rethrown as Laravel's `ValidationException`, which will result in a `422 Unprocessable Entity` http response in your typical Laravel Application.

¹: _`Aedart\Contracts\Filters\Exceptions\InvalidParameterException`_

### Advanced Input Validation

You can also use Laravel's [validator](https://laravel.com/docs/12.x/validation#manually-creating-validators) and let it do all the heavy lifting.
The `BaseProcessor` offers a reference to the validator factory, via the `getValidatorFactory()` method.

```php
class SimpleSearchProcessor extends BaseProcessor
{
    public function process(BuiltFiltersMap $built, callable $next)
    {
        $validator = $this->getValidatorFactory()->make(
            // The input...
            [
                'value' => $this->value()
            ],
            
            // Validation rules...
            [
                'value' => 'required|string|min:3|max:150'
            ]
        );
        
        // Obtain valid input... or fail
        $validated = $validator->validated();
        
        // ... remaining not shown
    }
}
```

## Built Filters Map

The `BuiltFiltersMap` DTO is intended be used as a temporary placeholder of all the filters that processors created.

### Add filters

To add one or more filters, from your processor, use the `add()` method.
It accepts two arguments:

* `$key`: _`string` key name._ 
* `filter`: _`Criteria` the [query filter](../database/query/criteria.md)._

```php
// ... inside your processor's process method ...

$built->add('my-parameter', new SearchFilter());
```

If a key already exists, then new filters are simply added to that key. This means that the same key can hold **multiple** query filters.

### Obtain filters

To obtain filters, you can use the `get()` method.

```php
$filters = $built->get('my-parameter');
```

### Obtain all filters

The `all()` method will return a list of all added filters.

```php
$filters = $built->all();
```

### Arbitrary meta data

Sometimes, your processor might be required to store additional arbitrary data that other processors can use.
If that is the case, then you can use `setMeta()` and `getMeta()` methods to do so.

```php
// E.g. inside first processor...
$built->setMeta('use_admin_flag', true);

// E.g. inside another processor...
$useAdminFlag = $built->getMeta('use_admin_flag', false);
```

See `Aedart\Contracts\Filters\BuiltFiltersMap` for additional reference of available methods.
