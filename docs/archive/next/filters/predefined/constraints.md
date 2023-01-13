---
description: Constraints Processor
sidebarDepth: 0
---

# Constraints Processor

As the name implies, the `ConstraintsProcessor` is able to create constraint query filters, e.g. "`where column operator value`".
The http query string format is slightly inspired by [JSON API](https://jsonapi.org/format/#fetching-filtering).
The accepted format is:

* `?identifier[property][operator]=value`

**Example**

* `?filter[name][contains]=Smith&filter[is_admin][eq]=true`

The shown query string will create a query that matches records where `name` contains `Smith` and `is_admin` state is set to `true`.

[[TOC]]

## Setup

When configuring the processor, you must specify the properties and their corresponding ["field filter"](../../database/query/criteria.md#field-criteria-field-filter) that can be applied, when requested.

```php
use Aedart\Filters\Processors\ConstraintsProcessor;
use Aedart\Filters\Query\Filters\Fields\NumericFilter;
use Aedart\Filters\Query\Filters\Fields\StringFilter;
use Aedart\Filters\Query\Filters\Fields\BooleanFilter;
use Aedart\Filters\Query\Filters\Fields\DatetimeFilter;

class UserFilterBuilder extends BaseBuilder
{
    public function processors(): array
    {
        return [
            'filter' => ConstraintsProcessor::make()
                ->filters([
                    'id' => NumericFilter::class,
                    'name' => StringFilter::class,
                    'email' => StringFilter::class,
                    'administrator' => BooleanFilter::class,
                    'email_verified' => DatetimeFilter::class,
                    'created_at' => DatetimeFilter::class,
                    'updated_at' => DatetimeFilter::class,
                ])
            
            // ...etc
        ];
    }
}
```

### Properties to column names

Similar to how you can map properties to table column names on the [`SortingProcessor`](./sort.md#properties-to-column-names), the "constraints" processor also offers a `propertiesToColumns()` method, which can be used to map requested properties to table columns.

```php
return [
    'filter' => ConstraintsProcessor::make()
        ->filters([
            'name' => StringFilter::class,
            'email' => StringFilter::class,
            'administrator' => BooleanFilter::class,
            'email_verified' => DatetimeFilter::class,
        ])
        ->propertiesToColumns([
            'administrator' => 'is_admin',
            'email_verified' => 'email_verified_at'
        ]);
];
```

### Maximum amount of allowed filters

By default, `10` properties are allowed requested to be filtered. When more are requested, then a validation exception will be thrown that results in a `422 Unprocessable Entity` response.
To change this limit, use the `maxFilters()` method.

```php
return [
    'filter' => ConstraintsProcessor::make()
        ->maxFilters(15)
        // ...remaining processor config. not shown ...
];
```

### Logical `AND` / `OR`

When multiple properties are requested, then constraint filters are applied using logical `AND` operator.
If you wish to allow `OR` operator, then please see the [`MatchingProcessor` documentation](./match.md) for details.

## Available Filters

Within the `Aedart\Filters\Query\Filters\Fields\` namespace, you will find a few predefined ["field filter"](../../database/query/criteria.md#field-criteria-field-filter).
These can be applied per allowed filterable property.

* `NumericFilter` matches value against numeric column
* `StringFilter` matches value against string column
* `BooleanFilter` marches value against boolean column
* `DateFilter` matches value against date column (_`Y-m-d`_)
* `DatetimeFilter` matches value against datetime column (_`Y-m-d H:i:s`_)
* `UTCDatetimeFilter` matches value against datetime column (_`Y-m-d H:i:s`_). Given date is converted to UTC, before matched against database value
* `BelongsToFilter` able to constrain relations of the type "belongs to" (_see further below for example_)

### Operators

All available filters support a variety of operators, which can be requested in the http query string.
These operators are either mapped directly to an SQL comparison operator or function, which is then applied in the query.

**Example**

* `eq` = `=`
* `ne` = `!=`
* `gt` = `>`
* `lt` = `<`
* `is_null` = `is null`,
* `contains` = `like %value%`

If an unsupported operator is requested, then the request is aborted - a `422 Unprocessable Entity` response is returned.
Please review each filter's source for a full list of supported operators.

### Create your own filters

If the available filters are not sufficient, then you can create your own filters, which can be supported by the "constraints" processor.
The easiest way of doing so, is by extending the `BaseFieldFilter` abstraction.

**Example**:

```php
use Aedart\Filters\Query\Filters\Fields\BaseFieldFilter;

class MyFilter extends BaseFieldFilter
{
    public function apply($query)
    {
        $operator = $this->operator();

        switch ($operator) {
            case 'special':
                return $query->where($this->field(), '%', $this->value());

            default:
                return $this->buildDefaultConstraint($query);
        }
    }

    public function operatorAliases(): array
    {
        return [
            'eq' => '=',
            'ne' => '!=',

            'special' => 'special' 
        ];
    }
    
    protected function assertValue($value)
    {
        // The assert method can be used to validate the requested value.
        // Throw an InvalidArgumentException, if value is invalid.
        // The processor will take care of the rest...
    
        if ((int) $value < 1) {
            throw new InvalidArgumentException('Value must be above 1');
        }
    }
}
```

### `BelongsToFilter` Example

The `BelongsToFilter` is slightly more special in that you need to create an instance and specify the name of the relation you wish to constrain.

```php
use Aedart\Filters\Query\Filters\Fields\BelongsToFilter;

return [
    'filter' => ConstraintsProcessor::make()
        ->filters([
            'user' => BelongsToFilter::make()
                ->setRelation('owner'),
                
            // ...remaining not shown...
        ])
        ->propertiesToColumns([
            'user' => 'owner.id', // relation + name of column in related model
        ]);
];
```

#### String relation

By default, the belongs to filter assumes that the relation value to constrain is an integer. If you wish to constrain a string value instead, e.g. a string column, then use the `usingStringValue()` method.

```php
return [
    'filter' => ConstraintsProcessor::make()
        ->filters([
            'category' => BelongsToFilter::make()
                ->setRelation('categories')
                ->usingStringValue(),
                
            // ...remaining not shown...
        ])
        ->propertiesToColumns([
            'category' => 'categories.slug',
        ]);
];
```
