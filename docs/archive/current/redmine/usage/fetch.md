---
description: Fetch single or multiple resources
sidebarDepth: 0
---

# Fetch

Should you require more advanced filtering capabilities when fetching a single or multiple resources, then you can use the `fetch()` or `fetchMultiple()` methods. 
They accept a callback which allows you to specify a [query filter](../../http/clients/query) to be applied onto the request. 

```php
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Redmine\Resource;

$issue = Issue::fetch(1234, function(Builder $request, Resource $resource) {
    return $request->where('include', 'relations');
});
```

## Fetch Multiple

The `fetchMultiple()` allows you to paginate, via limit and offset. This is the preferred method to be used, when creating custom searches and filters.  

```php
$issues = Issue::fetchMultiple(function(Builder $request, Resource $resource) {
    return $request
        ->where('created_on', '><2020-01-01|2021-08-30')
        ->where('status_id', 'open')
        ->where('assigned_to_id', 'me');
}, 50, 2); // Limit 50 and offset 2...
```
