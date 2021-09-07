# Athenaeum Redmine (_API Client_)

A Laravel [Redmine](https://www.redmine.org/) API Client, that has been designed to look and feel like an [active record](https://en.wikipedia.org/wiki/Active_record_pattern).

**Example**:

```php
use Aedart\Redmine\Issue;
use Aedart\Redmine\Project;
use Aedart\Redmine\IssueCategory;
use Aedart\Contracts\Http\Clients\Requests\Builder;

// Create resources
$project = Project::create([
    'name' => 'Deus Ex',
    'identifier' => 'deus-ex'
]);

// Fetch list of resources, apply filters to http request...
$issues = Issue::fetchMultiple(function(Builder $request) {
    return $request->where('assigned_to_id', 'me');
});

// Change existing resources
$category = IssueCategory::findOrFail(1344);
$category->update([
    'name' => 'Business Goals'
]);

// ...or remove them
Issue::findOrFail(9874)
    ->delete();
```

## Compatibility

| Athenaeum Redmine Client | Redmine version |
|--------------------------|-----------------|
| From `v5.19`             | `>= v4.x`*      |

*:_This package might also work with newer versions of Redmine._

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

## Documentation

Please read the [official documentation](https://aedart.github.io/athenaeum/) for additional information.

## Repository

The mono repository is located at [github.com/aedart/athenaeum](https://github.com/aedart/athenaeum)

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
