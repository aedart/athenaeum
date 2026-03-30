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

## Compatibility and Limitations

Please consult yourself with [Redmine's Api documentation](https://www.redmine.org/projects/redmine/wiki/rest_api), and this [package's documentation](https://aedart.github.io/athenaeum/archive/current/redmine/)
for details concerning compatibility and limitations.

## Documentation

Please read the [official documentation](https://aedart.github.io/athenaeum/) for additional information.

## Repository

The mono repository is located at [github.com/aedart/athenaeum](https://github.com/aedart/athenaeum)

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
