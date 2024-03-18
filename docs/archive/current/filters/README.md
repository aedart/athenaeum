---
description: About the Filters Package
---

# Search Filter Utilities

Offers a way to create search and constraint [query filters](../database/query/criteria.md), based on received http query parameters.

## Example

**Your custom filters builder**

By extending the `BaseBuilder` abstraction, you can encapsulate a custom filters builder.
Whenever a http query parameter is matched, a corresponding "processor" is invoked, which is responsible for creating one or more query filters.

```php
namespace Acme\Filters;

use Aedart\Filters\BaseBuilder;
use Acme\Filters\Processors\MySearchProcessor;
use Acme\Filters\Processors\TextProcessor;
use Acme\Filters\Processors\DateProcessor;
use Acme\Filters\Processors\SortProcessor;

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

**In your request**

To use your custom filters builder, create a new instance in your request, e.g. in the [after validation hook](https://laravel.com/docs/11.x/validation#after-validation-hook).

```php
namespace Acme\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Aedart\Contracts\Filters\BuiltFiltersMap;
use Acme\Filters\UserFilterBuilder;

class ListUsersRequest exends FormRequest
{
    public ?BuiltFiltersMap $filters = null;

    public function afterValidation(Validator $validator)
    {        
        // Using your custom filters builder, build filters
        // for this request...
        $this->filters = UserFilterBuilder::make($this)
            ->build();
    }

    // ... remaining not shown ...
}
```

**In your controller**

Lastly, apply the filters directly on your model.

```php
use App\Http\Controllers\Controller;
use App\Models\User;
use Acme\Requests\ListUsersRequest;

class UsersController extends Controller
{
    public function index(ListUsersRequest $request)
    {
        // Apply all requested filters...
        return User::applyFilters($request->filters->all())
            ->paginate(10);
        );
    }
}
```
