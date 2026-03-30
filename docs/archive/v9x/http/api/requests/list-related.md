---
description: Http Api Validated Requests - List Related Request
sidebarDepth: 0
---

# List Related

`ListRelatedResourcesRequest` is intended for situations when a list of related resources must be shown.
Similar to [List Resources](./list-resources.md), this request abstraction supports filtering and pagination.

[[TOC]]

**Example Request**

```php
use Aedart\Contracts\Filters\Builder;
use Aedart\Http\Api\Requests\Resources\ListRelatedResourcesRequest;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Game;
use App\Http\Filters\GameFiltersBuilder;

class ListUserGames extends ListRelatedResourcesRequest
{
    public function findRecordOrFail(): Model
    {
        return User::findOrFail($this->route('id'));
    }

    public function filtersBuilder(): string|Builder|null
    {
        return GameFiltersBuilder::class;
    }

    public function authorisationModel(): string|null
    {
        return Game::class;
    }
}
```

**Example Action**

```php
Route::get('/users/{id}/games', function (ListUserGames $request) {
    $user = $request->record;
    
    // E.g. find, filter and paginate related games...
    $games = $user
            ->games()
            ->applyFilters($request->filters->all())
            ->paginate($request->show);
 
    return GameResource::collection($games);
})->name('users.games');
```

## Authorisation

This kind of request performs two ability checks.
The first is via `authorize()`, which checks if the user is granted an `index` ability for the related resource (_e.g. `games.index`_).
The second is via `authorizeFoundRecord()`, in which the `show` ability is checked for the requested resource (_e.g. `users.show`_).

## Request Preconditions

The same recommendation for preconditions evaluation applies for "list related" requests, as for [List Resources](./list-resources.md#request-preconditions) requests.