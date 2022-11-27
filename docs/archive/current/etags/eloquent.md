---
description: ETags for your Eloquent Models
sidebarDepth: 0
---

# Eloquent Models

Although the default provided [`Generator`](./generators/README.md) is able to create an etag representation of your [Eloquent Models](https://laravel.com/docs/9.x/eloquent),
it is NOT the best suited (_nor fastest_) approach.

When creating an `Etag` for an Eloquent model, the default generator (`GenericGenerator`) will use the model's properties returned by `toArray()` and attempt to make a string representation of the entire array's content.
It will work, but it can be very costly in terms of performance.

```php
use Aedart\ETags\Facades\Generator;

$etag = Generator::make($model); // Uses all properties returned by toArray()
```

If you are able to generalise what properties to use when creating etags, for all of your Eloquent Models, then perhaps you should [create a custom generator](./generators/custom.md) for your models.
Alternatively, if you need to customise what properties to be used, per model, then the following approach could be better suitable.

## Customise Model ETag value

This packages comes with a `EloquentEtag` trait, which enables your models to specify what value should be used, when creating an `ETag` representation of the given model.

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
        $name = $this->name ?? '';
        $updatedAt = optional($this->updated_at)->toRfc3339String(true) ?? '';
    
        if ($weak) {
            return "user_{$name}_{$updatedAt}";
        }
    
        $email = $this->email ?? '';
    
        return "user_{$name}_{$email}_{$updatedAt}";
    }    
}
```

**Note**: _For the same of simplicity, the above shown example assumes model does not have an `id`. However, in a real world situation, you most likely would use a model's unique key, if available._

Later in your application, you can simply invoke `getEtag()`, `getStrongEtag()` or `getWeakEtag()` to create an etag representation of your model.

```php
$etagA = $model->getStrongEtag();
$etagB = $model->getWeakEtag();

echo (string) $etagA; // E.g. "5af037bcfaaaf3bcc564004f22362c9274434512"
echo (string) $etagB; // E.g. W/"846b00e9"
```

### The `etagValue()` method

::: warning Caution
By default, when you use the `EloquentEtag` trait, your model will be able to create etags, even without overwriting or implementing the `etagValue()` method.
This does **NOT** offer any performance improvements, as the default implementation assumes it must use all of your model's attributes, when creating an `ETag` for "strong" comparison.

**Recommendation**: _you SHOULD always implement the `etagValue()` such that it fits your needs, rather than relying on the default behaviour._
:::

## Onward

You are strongly encouraged to review the source code of the `EloquentEtag` trait, to gain a better understanding of how things work. 
