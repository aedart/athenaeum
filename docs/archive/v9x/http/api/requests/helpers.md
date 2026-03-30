---
description: Http Api Validated Requests - Helpers
sidebarDepth: 0
---

# Helpers

[[TOC]]

## Route Parameters Validation

As an alternative to Laravel's [route parameters constraints](https://laravel.com/docs/12.x/routing#parameters-regular-expression-constraints), you can enable validation of received route parameters.
To do so, your request must use the `RouteParametersValidation` concern and implement a `routeParameterRules()` method.

**Example Request**

```php
use Aedart\Http\Api\Requests\Concerns\RouteParametersValidation;
use Aedart\Http\Api\Requests\Resources\ShowSingleResourceRequest;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ShowUser extends ShowSingleResourceRequest
{
    use RouteParametersValidation;

    public function routeParameterRules(): array
    {
        return [
            // Validation rules for a "user" route parameter...
            'user' => ['required', 'integer', 'gt:0']
        ];
    }

    public function findRecordOrFail(): Model
    {
        $id = $this->route('user'); // parameter is valid...
    
        return User::findOrFail($id);
    }

    // ...remaining not shown here...
}
```

**Example Action**

```php
Route::get('/users/{user}', function (ShowUser $request) {
    return UserResource::make($request->record);
})->name('users.show');
```

**Validator Instance**

A separate validator instance is used for validating route parameters than the one used for input validation.
To use a custom instance, overwrite the `makeRouteParametersValidator()` method.

```php
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

// ...inside your request...

protected function makeRouteParametersValidator(array $rules): Validator
{
    return ValidatorFacade::make(
        data: $this->route()->parameters(),
        rules: $rules
    );
}
```