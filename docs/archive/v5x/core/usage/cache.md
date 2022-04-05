---
description: How to use Cache
---

# Caching

To make use of Laravel's [Cache](https://laravel.com/docs/8.x/cache) component, you _should_ spend a bit of time configuring it.

[[TOC]]

## Configuration

In your `/configs/cache.php`, you will find several cache "stores", each having a driver.
Please ensure that your server environment and application supports the drivers, that you wish to make use of.
For instance, if you wish to use a "store" that requires [Redis](https://redis.io/) as a driver, then you must fulfill it's requirements. 
See Laravel's [Redis package](https://packagist.org/packages/illuminate/redis) and it's [documentation](https://laravel.com/docs/8.x/redis) for details.

In the example illustrated below, a "user-tags" store has been added.
It relies of the Redis driver, which uses a custom "users" [connection](https://laravel.com/docs/8.x/redis#configuration).

```php
<?php
return [
    // ... previous not shown ...

    'stores' => [

        'user-tags' => [
            'driver' => 'redis',
            'connection' => 'users',
        ],
    
        // ... other profiles (stores) ...

    ],

    // ... remaining not shown ...    
];
```

## Obtain Store

There are several approaches to obtain the cache repository, with your desired "store".
To better understand following approaches, please review the [Service Container chapter](container.md#resolving).

### Via `$app`

Given that you have direct access to your application instance (`$app`), use the `make()` method to obtain the cache repository. 

```php
<?php
// Cache Repository with "default" store
$cache = $app->make('cache');

$cache->put('foo', 'bar', 5 * 60);
$foo = $cache->get('foo');
```

If you wish to obtain a cache repository that uses a specific "store", then you need to specify it via the `store()` method.

```php
<?php
// Cache Repository with "user-tags" store
$cache = $app->make('cache')->store('user-tags');

$cache->put('foo', 'bar', 5 * 60);
$foo = $cache->get('foo');
```

### Via Facade

You can also use Laravel's `Cache` [Facade](https://laravel.com/docs/8.x/facades), to achieve the same result.

```php
<?php
use Illuminate\Support\Facades\Cache;

Cache::put('foo', 'bar', 5 * 60);
$foo = Cache::get('foo');
```

Use the `store()` method to obtain a cache repository that uses a specific "store".

```php
<?php
use Illuminate\Support\Facades\Cache;

Cache::store('user-tags')->put('foo', 'bar', 5 * 60);
$foo = Cache::store('user-tags')->get('foo');
```

### Via Aware-of Helper

Lastly, you can also make use of the `Cache` and `CacheFactory` [Aware-of Helpers](../../support/laravel).

```php
<?php

use Aedart\Support\Helpers\Cache\CacheTrait;

class UsersController
{
    use CacheTrait;

    public function index()
    {
        // Default "store"
        $cache = $this->getCache();
    
        // ... remaining not shown ...
    }
}
```

To obtain a specific store, you use the `CacheFactory` Aware-of helper.

```php
<?php

use Aedart\Support\Helpers\Cache\CacheFactoryTrait;

class UsersController
{
    use CacheFactoryTrait;

    public function index()
    {
        // Cache Repository with "user-tags" store
        $cache = $this->getCacheFactory()->store('user-tags');
    
        // ... remaining not shown ...
    }
}
```

### Create Own Aware-Of Helper

If you have multiple components that depend on a very specific cache "store", then you could make your own Aware-of helper, which automatically returns the desired "store".
Consider the following example.

```php
<?php

namespace Acme\Users\Cache;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Facades\Cache;

trait UserTagsCache
{
    protected ?Repository $userTagsCache = null;

    public function setUserTagsCache(?Repository $repository)
    {
        $this->userTagsCache = $repository;
        
        return $this;
    }
    
    public function getUserTagsCache(): ?Repository
    {
        if( ! $this->hasUserTagsCache()){
            $this->setUserTagsCache($this->getDefaultUserTagsCache());
        }
        return $this->userTagsCache;
    }
    
    public function hasUserTagsCache(): bool
    {
        return isset($this->userTagsCache);
    }
    
    public function getDefaultUserTagsCache(): ?Repository
    {
        $factory = Cache::getFacadeRoot();
        if (isset($factory)) {
            return $factory->store('user-tags');
        }
        
        return null;
    }
} 
```

Once your Aware-of Helper is completed, you can use it inside all components that depend on it.

```php
<?php

use Acme\Users\Cache\UserTagsCache;

class UsersController
{
    use UserTagsCache;

    public function index()
    {
        // Cache Repository with "user-tags" store
        $cache = $this->getUserTagsCache();
    
        // ... remaining not shown ...
    }
}
```
