---
description: Tip - Create base builder for your application
sidebarDepth: 0
---

# Tip: Create a base builder

You might find it useful to create a "base" [builder](./builder.md), for you application. Doing so will allow you to specify common [processors](./processor.md) and configuration.
The following shows a possible abstract builder, using the predefined processors that are available in this package.

[[TOC]]

## Example: abstract builder

```php
use Aedart\Filters\BaseBuilder as Builder;
use Aedart\Filters\Processors\MatchingProcessor;
use Aedart\Filters\Processors\SearchProcessor;
use Aedart\Filters\Processors\ConstraintsProcessor;
use Aedart\Filters\Processors\SortingProcessor;

abstract class BaseFiltersBuilder extends Builder
{
    public function processors(): array
    {
        return [
            'match' => MatchingProcessor::make(),

            'search' => SearchProcessor::make()
                ->columns($this->searchColumns()),

            'filter' => ConstraintsProcessor::make()
                ->filters($this->filters())
                ->propertiesToColumns($this->propertiesColumnsMap()),

            'sort' => SortingProcessor::make()
                ->sortable($this->sortable())
                ->propertiesToColumns($this->sortingPropertiesColumnsMap())
                ->defaultSort($this->defaultSorting())
                ->force()
        ];
    }

    /**
     * Get list of table columns that the search filter
     * must match search terms against
     *
     * @return string[]
     */
    abstract public function searchColumns(): array;

    /**
     * Get list of allowed filterable properties and
     * their corresponding filter to be used.
     *
     * @return array
     */
    abstract public function filters(): array;

    /**
     * Get map of properties and their corresponding table
     * column name.
     *
     * @return array
     */
    abstract public function propertiesColumnsMap(): array;

    /**
     * Map of properties and their corresponding table column name,
     * to be used for sorting.
     *
     * @see propertiesColumnsMap
     *
     * @return array
     */
    public function sortingPropertiesColumnsMap(): array
    {
        return $this->propertiesColumnsMap();
    }

    /**
     * Get list of sortable properties
     *
     * @return string[]
     */
    public function sortable(): array
    {
        return array_keys($this->filters());
    }

    /**
     * Get the default sorting value to be used, when
     * none is requested.
     *
     * @return string
     */
    abstract public function defaultSorting(): string;
} 
```

## Example: concrete builder

```php
class UsersFiltersBuilder extends BaseFiltersBuilder
{
    public function searchColumns(): array
    {
        return [
            'id',
            'name',
            'email',
        ];
    }

    public function filters(): array
    {
        return [
            'id' => NumericFilter::class,
            'name' => StringFilter::class,
            'email' => StringFilter::class,
            'administrator' => BooleanFilter::class,
            'email_verified_at' => DatetimeFilter::class,
            'created_at' => DatetimeFilter::class,
            'updated_at' => DatetimeFilter::class,
        ];
    }

    public function propertiesColumnsMap(): array
    {
        return [
            'administrator' => 'is_admin'
        ];
    }

    public function defaultSorting(): string
    {
        return 'id desc';
    }
}
```