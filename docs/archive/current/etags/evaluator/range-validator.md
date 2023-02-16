---
description: Range Validator
sidebarDepth: 0
---

# Range Validator

The [If-Range](./rfc9110/if-range.md) and [Range](./extensions/range.md) preconditions make use of `RangeValidator` component, whenever they are evaluated.
A default validator is automatically bound in the service container, when you register this package's service container.

[[TOC]]

## Default Behaviour

The default validator will ensure that the following are meet, when a `Range` header is available.

* Verify [range unit](https://httpwg.org/specs/rfc9110.html#range.units) (_e.g. bytes_) is supported / allowed.
* Verify that requested [range-sets](https://httpwg.org/specs/rfc9110.html#rule.ranges-specifier) do not exceed maximum amount (_See resource context's [`$maxRangeSets` argument](./resource-context.md)_)
* Verify that requested ranges-sets do not overlap.
* Wrap requested range-sets into a collection, which can then be set in the assigned [resource context](./resource-context.md).

Depending on what verification fails to meet desired expectation, the validator will abort the request via its assigned [actions](./actions.md). 
The result is that either of the following responses are returned by your application:

* [400 Bad Request](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/400)
* [416 Range Not Satisfiable](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/416)

## Custom Validator

If the default provided range validator is not to your liking, you can create your own.
This can be done either by extending the default or by inheriting from `\Aedart\Contracts\ETags\Preconditions\RangeValidator`.

```php
use Aedart\Contracts\ETags\Preconditions\RangeValidator;
use Aedart\ETags\Preconditions\Concerns;
use Aedart\Contracts\ETags\Preconditions\Ranges\RangeSet;
use Ramsey\Collection\CollectionInterface;

class MyCustomRangeValidator implements RangeValidator
{
    use Concerns\CurrentRequest;
    use Concerns\Actions;
    
    public function __construct(
        protected string $rangeUnit,
        protected int $maxRangeSets
    ) {}

    /**
     * Validates requested "Range" header field, for given resource
     *
     * @param  ResourceContext  $resource
     *
     * @return CollectionInterface<RangeSet>

     * @throws HttpExceptionInterface
     */
    public function validate(ResourceContext $resource): CollectionInterface
    {
        // ... validation logic not shown here...
    }

    public function allowedRangeUnit(): string
    {
        return $this->rangeUnit;
    }

    public function maximumRangeSets(): int
    {
        return $this->maximumRangeSets;
    }
}
```

::: tip Constructor Arguments
The `__construct()` arguments (`rangeUnit` and `maxRangeSets`) are required.
These will be provided by the internal mechanisms of the If-Range and Range preconditions.
:::

### Register Custom Validator

To use your custom range validator, you must bind it in the application's service container.
This can, for instance, be done in your `AppServiceProvider`.

```php
namespace App\Providers;

use Aedart\Contracts\ETags\Preconditions\RangeValidator;
use App\Validators\Http\MyCustomRangeValidator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(RangeValidator::class, function ($app, array $args = []) {
            $unit = $args['rangeUnit'] ?? 'bytes';
            $maxRanges = $args['maxRangeSets'] ?? 5;

            return new MyCustomRangeValidator($unit, $maxRanges);
        });
    }
    
    // ... remaining not shown ...
}
```