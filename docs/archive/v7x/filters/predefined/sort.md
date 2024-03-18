---
description: Sorting Processor
sidebarDepth: 0
---

# Sorting Processor

To enable sorting by columns in ascending or descending order, use the `SortingProcessor`.
It accepts a comma separated value, from the http query parameter, which determines the "properties" and sorting order. 

**Example**: _`https://my-app.org/api/v1/users?sort=name asc,updated_at desc` will result in a sql `order by` clause, in which `name` and `updated_at` columns specified, along with the requested sorting direction._

[[TOC]]

## Setup

As a minimum, you must specify the table column names that are sortable, using the `sortable()` method. 

```php
use Aedart\Filters\Processors\SortingProcessor;

class UserFilterBuilder extends BaseBuilder
{
    public function processors(): array
    {
        return [
            'sort' => SortingProcessor::make()
                ->sortable([
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at'
                ]),
            
            // ...etc
        ];
    }
}
```

### Default sorting

If you wish to enable default sorting, then you can the `defaultSort()` method, along with the `force() which will ensure that the processor is always applied, regardless whether a matching http query parameter was received or not.
The method accepts a string value, which is expected formatted as you would normally request sorting.

```php
return [
    'sort' => SortingProcessor::make()
        ->sortable([
            'id',
            'name',
            'email',
            'created_at',
            'updated_at'
        ])
        ->defaultSort('created_at desc')
        ->force(),
];
```

### Properties to column names

When the "properties" that your application or API exposes do not match your table columns directly, then you can use the `propertiesToColumns()` method.
For instance, if your application uses a property named "administrator", which corresponds to a `is_admin` column name, then you can use the mentioned method to ensure that it's automatically mapped, when processed.

```php
return [
    'sort' => SortingProcessor::make()
        ->sortable([
            'name',
            'is_admin'
        ])
        ->propertiesToColumns([
            'administrator' => 'is_admin'
        ]);
];
```

In the above example, if the following request is made:

* `https://my-app.org/api/v1/users?sort=administrator desc`

Then, the processor will map "administrator" to the correct table column name, before creating the query filter.
The result is that the applied query will contain a `order by is_admin desc` clause.

### Maximum allowed properties

By the default, the processor will throw a validation exception (_results in a `422 Unprocessable Entity` http response_), whenever more than `3` properties are requested sorted.
This can be changed using the `maxSortingProperties()` method.

```php
return [
    'sort' => SortingProcessor::make()
        ->sortable([
            'id',
            'name',
            'email',
            'updated_at'
        ])
        ->maxSortingProperties(4)
];
```

### Sorting direction identifiers

`asc` and `desc` are used as the default sorting direction identifiers. You may change these via the `directions()`, which accepts an array containing key-value pairs:

* key = identifier
* value = sql sorting direction

```php
return [
    'sort' => SortingProcessor::make()
        ->sortable([
            'email',
            'name',
        ])
        ->directions([
            '+' => 'asc',
            '-' => 'desc'
        ])
];
```

Using the above shown setup, sorting requests are then expected to be formatted in the following way:

* `https://my-app.org/api/v1/users?sort=name -,email +`

Should you require more advanced formatting, then you are encouraged to extend the `SortingProcessor` and overwrite either of the following internal methods:

* `extractSortingColumn()`: responsible for extracting the table column name
* `extractSortingDirection()`: responsible for extracting the SQL sorting direction
* `splitSortableItem()`: responsible for splitting a sorting value into an array

Furthermore, you may also specify a different symbol for distinguishing between multiple properties and sorting direction, by changing the `$delimiter` property.
See the source code for additional information.

### Custom Sorting Queries

When you require special sorting logic, you can specify custom queries for each column.
These queries have to be set apart from the sortable properties.

```php
$processor = SortingProcessor::make()
        ->sortable([ 'email', 'name'])
        
        // Custom query per column via an array...
        ->withSortingCallbacks([
            'name' => function($query, $column, $direction) {
                return $query->orderBy("users.{$column}", $direction);
            },
            
            // ...etc
        ])

        // Or just for a single column...
        ->withSortingCallback('email', function($query, $column, $direction) {
            return $query->orderBy("users.{$column}", $direction);
        });
```

You can also wrap your custom sorting query into an invokable class, e.g.:

```php
use Aedart\Filters\Query\Filters\BaseSortingQuery;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;

class MyCustomSorting extends BaseSortingQuery
{
    public function __invoke(
        Builder|EloquentBuilder $query,
        string $column,
        string $direction = 'asc'
    ): Builder|EloquentBuilder
    {
        return $query->orderBy("users.{$column}", $direction);
    }
}

// ...In your sorting processor
$processor = SortingProcessor::make()
        ->withSortingCallback('name', new MyCustomSorting());
```