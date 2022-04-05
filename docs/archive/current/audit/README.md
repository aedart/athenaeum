---
description: About the Audit Package
sidebarDepth: 0
---

# Audit

An [audit trail](https://en.wikipedia.org/wiki/Audit_trail) package for Laravel Eloquent Model.
It is able to store the changes made on a given model into an "audit trails" table, along with the attributes that have been changed.

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
