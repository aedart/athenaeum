---
description: Http Api Resource Timestamps
sidebarDepth: 0
---

# Timestamps

If your model has timestamps, e.g. `created_at`, `updated_at` and perhaps `deleted_at`, then you can quickly format and show these timestamps by using the `withTimestamps()` method.

[[TOC]]

```php
use Aedart\Http\Api\Resources\ApiResource;
use Illuminate\Http\Request;
use App\Models\Address;

/**
 * @mixin Address
 */
class AddressResource extends ApiResource
{
    public function formatPayload(Request $request): array
    {
        return $this->withTimestamps([
            'id' => $this->id,
            'street' => $this->street,
            'postal_code' => $this->postal_code,
            'city' => $this->city
        ]);
    }

    public function type(): string
    {
        return 'address';
    }
}
```

Corresponding JSON output:

```json
{
    "data": {
        "id": 5,
        "street": "24924 Macey Hill Suite 432",
        "postal_code": "17092",
        "city": "South Eric",
        "created_at": "2022-10-21T15:30:25+00:00",
        "updated_at": "2022-10-21T15:30:25+00:00"
    },
    "meta": {
        "type": "address",
        "self": "http://localhost/addresses/5"
    }
}
```

## Soft-Deletes

In case your model has been soft-deleted and your API allows obtaining it, then the corresponding JSON output will contain a `deleted_at` timestamp, as well as a `deleted` property:

```json
{
    "data": {
        "id": 5,
        "street": "24924 Macey Hill Suite 432",
        "postal_code": "17092",
        "city": "South Eric",
        "created_at": "2022-10-21T15:30:25+00:00",
        "updated_at": "2022-10-21T15:30:25+00:00",
        "deleted": true,
        "deleted_at": "2022-10-22T08:24:05+00:00"
    },
    "meta": {
        "type": "address",
        "self": "http://localhost/addresses/5"
    }
}
```

## Customise Timestamps

To customise timestamps, e.g. to add additional timestamps or alter the output names of existing, overwrite the `$timestampsMap` property.

```php
use Aedart\Http\Api\Resources\ApiResource;
use Illuminate\Http\Request;
use App\Models\Address;

/**
 * @mixin Address
 */
class AddressResource extends ApiResource
{
    /**
     * Timestamps
     *
     * @var array Key = Eloquent model property name, value = payload key
     */
    protected array $timestampsMap = [
        'created_at' => 'created',
        'updated_at' => 'last_updated',
    ];

    public function formatPayload(Request $request): array
    {
        return $this->withTimestamps([
            'id' => $this->id,
            'street' => $this->street,
            'postal_code' => $this->postal_code,
            'city' => $this->city
        ]);
    }

    public function type(): string
    {
        return 'address';
    }
}
```

### Soft-Delete Timestamp

To customise the timestamp shown for when a model is soft-deleted, you must overwrite the `getSoftDeleteTimestamps()` method.

For instance:

```php
// ...inside your Api Resource...

public function getSoftDeleteTimestamps(mixed $resource): array
{
    return [
        'is_deleted' => !empty($resource->deleted_at),
        'delete_date' => $this->formatDatetime($resource->deleted_at)
    ];
}
```
