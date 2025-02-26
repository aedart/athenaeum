---
description: Http Api Validated Requests - Create Single Resource Request
sidebarDepth: 0
---

# Create Resource

The `CreateSingleResourceRequest` is intended for when a new resource must be created.

[[TOC]]

**Example Request**

```php
use Aedart\Http\Api\Requests\Resources\CreateSingleResourceRequest;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class CreateUser extends CreateSingleResourceRequest
{

    public function authorisationModel(): string|null
    {
        return User::class;
    }

    public function mustEvaluatePreconditions(): bool
    {
        return false;
    }

    public function rules(): array
    {
        // Validation rules of data that you require...
        return [
            'email' => 'required|email|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)]
        ];
    }
}
```

**Example Action**

```php
use Illuminate\Support\Facades\Hash;

Route::post('/users', function (CreateUser $request) {
    $data = $request->validated();
    
    $user = User::create([
        'email' => $data['email'],
        'password' => Hash::make($data['email'])
    ]);

    return UserResource::make($user)
        ->createdResponse();
})->name('users.store');
```

## Authorisation

The request will check against a `store` ability.
From the above shown examples, a `users.store` ability is checked.

## Request Preconditions

If you choose to enable preconditions evaluation via the `mustEvaluatePreconditions()`, for this kind of request, then the default behaviour is to use the **_current datetime_** as the `Last-Modified` date.
No ETag is generated for the received input data.
Furthermore, the received input data is used as "record", which is wrapped into a resource context.

To customise this behaviour, you can overwrite the following methods:

```php
use Aedart\Contracts\ETags\ETag;
use Aedart\Http\Api\Requests\Resources\CreateSingleResourceRequest;
use DateTimeInterface;

class CreateUser extends CreateSingleResourceRequest
{
    // ...previous not shown...
    
    protected function wrapData(array $data): mixed
    {
        // Prepare data to be used as "record" for Resource Context
        // ...not shown here...
        
        return $data;
    }
    
    protected function generateEtag(array $data): ETag|null
    {
        // Generate etag for received input data (if feasible)
        // ...not shown here...
        
        return null;
    }
    
    protected function generateLastModifiedDate(array $data): DateTimeInterface|null
    {
        return now();
    }
}
```

See [Show Request](./show-single.md#request-preconditions) for details regarding how to configure request preconditions evaluation.