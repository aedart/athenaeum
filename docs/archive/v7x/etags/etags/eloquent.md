---
description: ETags for your Eloquent Models
sidebarDepth: 0
---

# Eloquent Models

Although the default provided [`Generator`](generators/README.md) is able to create an etag representation of your [Eloquent Models](https://laravel.com/docs/10.x/eloquent),
it is NOT the best suited (_nor fastest_) approach.

When creating an `Etag` for an Eloquent model, the default generator (`GenericGenerator`) will use the model's properties returned by `toArray()` and attempt to make a string representation of the entire array's content.
It will work, but it can be very costly in terms of performance.

```php
use Aedart\ETags\Facades\Generator;

$etag = Generator::make($model); // Uses all properties returned by toArray()
```

If you are able to generalise what properties to use when creating etags, for all of your Eloquent Models, then you can [create a custom generator](generators/custom.md) for your models.
Alternatively, if you need to customise what properties must be used, per model, then the following approach could be more suitable.

## Customise Model ETag value

The `EloquentEtag` trait enables your models to specify what value should be used, when creating an etag representation of the given model.

Consider the following example:

```php
namespace App\Models;

use Aedart\ETags\Concerns\EloquentEtag;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use EloquentEtag;
    
    public function etagValue(bool $weak = true): mixed
    {
        $id = $this->getKey() ?? '';
        $updatedAt = optional($this->updated_at)->toRfc3339String(true) ?? '';
    
        if ($weak) {
            return "users_{$id}_{$updatedAt}";
        }

        $email = $this->email ?? '';
    
        return "users_{$id}_{$email}_{$updatedAt}";
    }    
}
```

**Note**: _For the sake of the example, an additional property is added (`email`) when value is to be used for a "strong comparison" etag. Feel free to ignore `$weak` if you do not require such logic._

Later in your application, you can simply invoke `getEtag()`, `getStrongEtag()` or `getWeakEtag()`, in order to create an etag representation of your model.

```php
$etagA = $model->getStrongEtag();
$etagB = $model->getWeakEtag();

echo (string) $etagA; // E.g. "5af037bcfaaaf3bcc564004f22362c9274434512"
echo (string) $etagB; // E.g. W/"846b00e9"
```

### The `etagValue()` method

::: warning Recommendation

_By default, you are not required to implement / overwrite the `etagValue()` method._
_However, it is recommended that you do overwrite this method and return the value(s) that best fit your needs._

_Furthermore, you SHOULD handle situations when your model instance does not have the required attributes to return a value. E.g. by throwing an exception or default to other appropriate behaviour._

:::
 
