---
description: Filters Builder
---

# Filters Builder

A filter builder is responsible for invoking all assigned [processors](./processor.md), given that matching http query parameters are matched.

[[TOC]]

## How to create a Filter Builder

Extend the `BaseBuilder` abstraction and implement the `processors()` method.
The output of the method is expected to be a map of http query parameters and corresponding processors that must be applied, if parameters are received.

```php
use Aedart\Filters\BaseBuilder;

class UserFilterBuilder extends BaseBuilder
{
    public function processors(): array
    {
        // Key = http query parameter, value = parameter processor...
        return [
            'search' => MySearchProcessor::make(),
            
            'name' => TextProcessor::make(),
            
            'created_at' => DateProcessor::make(),
            
            'sort' => SortProcessor::make()
                ->force(),
            
            // ...etc
        ];
    }
}
```

## How to use Builder

Once you have created your builder, you can instantiate a new instance in your [Form Request](https://laravel.com/docs/9.x/validation#form-request-validation).
The [after validation hook](https://laravel.com/docs/9.x/validation#after-validation-hook) is a possible place, where you can create a new builder instance.
However, feel free to initialise your builder where it suits you the most.

Call the `build()` method to trigger the processing of http query parameters. The method returns the `BuiltFiltersMap` DTO, which contains all query filters that must be applied. 

```php
use Illuminate\Foundation\Http\FormRequest;

class ListUsersRequest exends FormRequest
{
    public ?BuiltFiltersMap $filters = null;

    public function after(Validator $validator)
    {        
        $this->filters = UserFilterBuilder::make($this)
            ->build();
    }

    // ... remaining not shown ...
}
```

### Apply filters on model

To apply all query filters, use the `applyFilters()`, in your Eloquent model.
See [query filters documentation](../database/query/criteria.md) for additional information.

```php
// ... inside your controller...
$filters = $request->filters->all();
$result = Users::applyFilters($filters)->get();
```

## Force run Processor

By default, if received http query parameters do not match any of the names stated in the `processors()` method's resulting `array`, then processors are not invoked.
If you wish to change this behavior, then us the `force()` method on those processors that always must be triggered, regardless of matching query parameters are received or not.

```php
class UserFilterBuilder extends BaseBuilder
{
    public function processors(): array
    {
        return [
            // Force run processor, regardless if "sort"
            // was submitted or not...      
            'sort' => SortProcessor::make()
                ->force(),
            
            // ...etc
        ];
    }
}
```

## Onward

By now, you should be able to create your own customised search filters, based on the received input from http query parameters.
In the next section, you will find a few [predefined resource](./predefined/README.md). These may be useful for you, or perhaps act as inspiration for your own processors and filters. 
