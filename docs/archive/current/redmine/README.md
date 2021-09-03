---
description: Redmine API Client
---

# Redmine Api Client

_**Available since** `v5.19.x`_

A Laravel [Redmine](https://www.redmine.org/) API Client, that has been designed as look and feel like an [active record](https://en.wikipedia.org/wiki/Active_record_pattern).  

**Example**: 

```php
use Aedart\Redmine\Issue;
use Aedart\Contracts\Http\Clients\Requests\Builder;

// Fetch issues that are assigned to your account...
$issues = Issue::fetchMultiple(function(Builder $request) {
    return $request->where('assigned_to_id', 'me');
});
```

## Compatibility

| Athenaeum Redmine Client | Redmine version |
|--------------------------|-----------------|
| From `v5.19`             | `4.x`           |


## Limitations

This package offers "Resources" that cover most of Redmine's [REST Api](https://www.redmine.org/projects/redmine/wiki/rest_api).
Yet, if you have previously worked with Redmine's API, then you know that it can be somewhat inconsistent. Depending on the resource that you are working with, you might not be able to perform certain operations, because it's not supported by the API.
You might therefore experience the following exception:

```php
\Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException
```

Please consult yourself with [Redmine's Api documentation](https://www.redmine.org/projects/redmine/wiki/rest_api), to review what operations the current API version supports.

## Alternative

You might also be interested in alternative Redmine API Clients:

* [tuner88/laravel-redmine-api](https://packagist.org/packages/tuner88/laravel-redmine-api), Laravel wrapper for `kbsali/redmine-api`
* [limetecbiotechnologies/redmineapibundle ](https://packagist.org/packages/limetecbiotechnologies/redmineapibundle), Symfony wrapper for `kbsali/redmine-api` 
* [kbsali/redmine-api](https://packagist.org/packages/kbsali/redmine-api)