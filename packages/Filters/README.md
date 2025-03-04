# Athenaeum Filters

Offers a way to create search and constraint [query filters](https://aedart.github.io/athenaeum/archive/current/database/query), based on received http query parameters, for your [Laravel](https://laravel.com/) application.

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

To use your custom filters builder, create a new instance in your request, e.g. in the [after validation hook](https://laravel.com/docs/8.x/validation#after-validation-hook).

```php
namespace Acme\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Aedart\Contracts\Filters\BuiltFiltersMap;
use Acme\Filters\UserFilterBuilder;

class ListUsersRequest exends FormRequest
{
    public BuiltFiltersMap|null $filters = null;

    public function after(Validator $validator)
    {        
        // Add filters using your custom builder
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

## Official Documentation

Please read the [official documentation](https://aedart.github.io/athenaeum/) for additional information.

The mono repository is located at [github.com/aedart/athenaeum](https://github.com/aedart/athenaeum)

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
