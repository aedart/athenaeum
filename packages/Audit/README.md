# Athenaeum Audit

An audit trail package for Laravel Eloquent Model. Stores the changes made on a given model into an "Audit Trails" table, along with the attributes that have been changed.

## Example

```php
namespace Acme\Models;

use Illuminate\Database\Eloquent\Model;
use Aedart\Audit\Traits\RecordsChanges;

class Category extends Model
{
    use RecordsChanges;
}
```

Later in your application...

```php
$category = Category::create( [ 'name' => 'My category' ]);

// Obtain the "changes" made (in this case a "create" event) 
$changes = $category->recordedChanges()->first();

print_r($changes->toArray());

// Example output:
//    [
//      "id" => 1
//      "user_id" => null
//      "auditable_type" => "Acme\Models\Category"
//      "auditable_id" => "24"
//      "type" => "created"
//      "message" => "Recording created event"
//      "original_data" => null
//      "changed_data" => [
//        "name" => "My Category"
//        "id" => 1
//      ]
//      "performed_at" => "2021-04-28T11:07:24.000000Z"
//      "created_at" => "2021-04-28T11:07:24.000000Z"
//    ]
```

## Documentation

Please read the [official documentation](https://aedart.github.io/athenaeum/) for additional information.

## Repository

The mono repository is located at [github.com/aedart/athenaeum](https://github.com/aedart/athenaeum)

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
