---
description: Search Processor
sidebarDepth: 0
---

# Search Processor

The `SearchProcessor` creates a simple search query filter. It compares a search term against one or more table columns, using SQL's `like` operator.
If you do not have a huge amount of records, then this processor might be a good starting point.

## Setup

In your [builder](../builder.md), specify the http query parameter name and the database table columns that the search filter must compare a search term against. 

**Note**: _You should only specify numeric or string datatype columns. Other types of columns might not yield positive results._

```php
use Aedart\Filters\Processors\SearchProcessor;

class UserFilterBuilder extends BaseBuilder
{
    public function processors(): array
    {
        return [
            'search' => SearchProcessor::make()
                ->columns([ 'id', 'name', 'email' ]),
            
            // ...etc
        ];
    }
}
```

### Maximum length of search term

By default, the processor will raise a validation exception (_results in a `422 Unprocessable Entity` http response_), if the submitted search term is more than `100` characters.
To change this behaviour, use `maxSearchLength()` to specify a different maximum length.

```php
return [
    'search' => SearchProcessor::make()
        ->columns([ 'id', 'name', 'email' ])
        ->maxSearchLength(150),
];
```