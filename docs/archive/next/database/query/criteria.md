---
description: Criteria / Query Filters
---

# Criteria (Query Filter)

A way to encapsulate custom queries for your Eloquent models. These can be used as an alternative or complementary to Laravel's [query scopes](https://laravel.com/docs/9.x/eloquent#query-scopes). 

[[TOC]]

## How to create a new filter

Extend the `Filter` abstraction and implement the `apply()` method.

```php
use Aedart\Database\Query\Filter;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;

class VideoGamesCategoryFilter extends Filter
{
    public function apply(Builder|EloquentBuilder $query)
    {
        return $query->where('name', '=', 'Video Games');
    }
}
```

## How to use

Once you have your filter created, you can apply it in your Eloquent model.
Use the `Filtering` trait and call the `applyFilters()` method.

**In your model**

```php
use Illuminate\Database\Eloquent\Model;
use Aedart\Database\Models\Concerns\Filtering;

class Category extends Model
{
    use Filtering;
}
```

**Apply filter**

```php
$result = Category::applyFilters(new VideoGamesCategoryFilter())->first();
```

### Apply Multiple Filters

The `applyFilters()` accepts either a single filter instance or a list of filters.

```php
$result = Category::applyFilters([
    new OldRecords(),
    new HasDiscounts(),
    new NotDeleted()
])->get()
```

## Applicability

Each filter has a `isApplicable()` method. It is used to determine whether the filter must be applied or not.
By default, this method will always return `true`. However, if you need to exclude a filter, then you should overwrite this method.

Two parameters are provided:

* `$query`: The current query scope.
* `$filters`: List of all the filters that are about to be applied.

These parameters can be used for your determination logic, if it makes sense for you. Otherwise, simply ignore them. 

```php
use Aedart\Database\Query\Filter;
use Acme\Filters\IsDeleted;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;

class OldRecords extends Filter
{
    public function isApplicable(Builder|EloquentBuilder|null $query = null, $filters = []): bool
    {
        // Prevent this filter, if another specific filter is about
        // to be applied...
        foreach($filters as $filter) {
            if ($filter instanceof IsDeleted) {
                return false;
            }
        }
        
        return true;
    }

    // ... remaining not shown ... //
}
```

Whenever the above shown filter is used, in combination with a `IsDeleted` filter, it will be ignored and not applied.

```php
$result = Category::applyFilters([
    new OldRecords(), // Will be ignored
    new IsDeleted()
])->get()
```

## Field Criteria (Field Filter)

If you require filters that add `where <expression>` constraints for a single field (_column_) on your query, then you can choose to inherit from the `FieldFilter`.
This abstraction allows you to create slightly more constraints to be applied using either `AND` or `OR` logical operator.

```php
use Aedart\Database\Query\FieldFilter;
use Aedart\Contracts\Database\Query\FieldCriteria;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;

class StringFilter extends FieldFilter
{
    public function apply(Builder|EloquentBuilder $query)
    {
        if ($this->logical() === FieldCriteria::OR) {
            return $query->orWhere($this->field(), $this->operator(), $this->value());
        }

        return $query->where($this->field(), $this->operator(), $this->value());
    }
}
```

**Usage**

```php
use Aedart\Contracts\Database\Query\FieldCriteria;

$result = Category::applyFilters([
    StringFilter::make('name', 'LIKE', '%games%', FieldCriteria::OR),
    StringFilter::make('name', 'LIKE', '%video%', FieldCriteria::OR),
])->get()
```

How you choose to design your "field" specific filters, is left to your imagination.
For additional information, please review the source code.
