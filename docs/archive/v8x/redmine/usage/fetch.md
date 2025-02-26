---
description: Fetch single or multiple resources
sidebarDepth: 0
---

# Fetch

Should you require more advanced filtering capabilities when fetching a single or multiple resources, then you can use the `fetch()` or `fetchMultiple()` methods. 
They accept a callback which allows you to specify a [query filter](../../http/clients/query) to be applied onto the request.

```php
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Redmine\ApiResource;

$issue = Issue::fetch(1234, function(Builder $request, ApiResource $resource) {
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

## All

You may encounter situations where you need to fetch all available results for a given resource. This could for instance be several hundreds of issues.
If you use `fetchMultiple()`, then you will have to manually invoke again, and again, until you have paginated through all desired results.
Therefore, as an alternative to manually performing paginated requests, you can use the `all()` method. It will automatically perform requests, as you iterate through the results.
Consider the following example:

```php
// No request performed at this point - a traversable instance is returned
$issues = Issue::all(function(Builder $request, Resource $resource) {
    return $request
        ->where('created_on', '><2020-01-01|2021-08-30')
        ->where('status_id', 'open')
        ->where('assigned_to_id', 'me');
}, 50); // "Pool" size - amount of results per request

// Requests are ONLY performed when you iterate through
// available results.
foreach ($issues as $issue) {
    // ...do something with issue ... //
}
```

The `all()` method returns an `TraversableResults` instance, which contains a custom iterator that is able to perform API requests to Redmine, as needed, when you iterate through the results.

### Pool size

**Warning**: _Please read the following very carefully..._

The second argument of the `all()` method, is the maximum pool size ~ how many results a request should return from Redmine (_request limit_).
By default, it is set to `10`, which might not be fitting for your needs. You _SHOULD_ always specify a reasonable pool size.
If the size is too low and there are many records available, then your application's performance will decrease significantly, due to large amount of Http requests.

### Count all available results
 
The `TraversableResults` also allows you to count the total amount of records available, for your request.
Invoking this will not cost you extra requests, provided that you iterate through the results.

```php
$issues = Issue::all(null, 50);

// First request performed
echo count($issues); // E.g. 348

// First results set is already loaded. New request is only
// performed when record number 51 is reached in the iteration. 
foreach ($issues as $issue) {
    // ...do something with issue ... //
}
```

The above example will cost 7 requests, given a total of 348 records and a pool size of 50.
