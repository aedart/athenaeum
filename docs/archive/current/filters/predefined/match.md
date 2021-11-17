---
description: Matching Processor
sidebarDepth: 0
---

# Matching Processor

The `MatchingProcessor` is a complementary component to the [constraints](./constraints.md) processor.
It instructs how the constraint filters must be applied; using either a logical `AND` or via an `OR` operator.

By default, the processor maps the following identifiers to logical `AND/OR` operators:

* `all` = `AND` operator
* `any` = `OR` operator

**Example**

Consider the following http query string:

* `?filter[age][gt]=20&filter[created_at][gt]=2021-11-01&match=any`

The resulting query will match results where `age` is greater than `20`, or `created_at` is greater than `2021-11-01`.

## Setup

`MatchingProcessor` must be used in combination with the `ConstraintsProcessor`.
Furthermore, you must specify the "meta" key in which the resulting logical operator is stored, on the "constraints" processor.
_See `BuiltFiltersMap` [in the `Processor` documentation](../processor.md#built-filters-map) for additional information._

```php
use Aedart\Filters\Processors\MatchingProcessor;
use Aedart\Filters\Processors\ConstraintsProcessor;

class UserFilterBuilder extends BaseBuilder
{
    public function processors(): array
    {
        return [
            'match' => MatchingProcessor::make(),
            
            'filters' => ConstraintsProcessor::make()
                ->matchFrom('match')
                // ...additional constraints setup not shown...
            
            // ...etc
        ];
    }
}
```

### Change identifiers

If the default `all` and `any` identifiers are not to your liking, then you may change them via the `allows()` method.
It accepts a string identifier and the logical boolean operator that the identifier must be mapped to.

```php
use Aedart\Contracts\Database\Query\FieldCriteria;

return [
    'match' => MatchingProcessor::make()
        ->allows('and', FieldCriteria::AND)
        ->allows('or', FieldCriteria::OR)
];
```