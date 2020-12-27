<?php

namespace Aedart\Tests\Integration\Circuits\Stores;

use Aedart\Circuits\Stores\CacheStore;
use Aedart\Contracts\Circuits\Exceptions\StoreException;
use Aedart\Tests\TestCases\Circuits\CircuitBreakerTestCase;

/**
 * CacheStoreTest
 *
 * @group circuits
 * @group circuits-stores
 * @group circuits-stores-cache
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Circuits\Stores
 */
class CacheStoreTest extends CircuitBreakerTestCase
{
    /**
     * test
     *
     * @see https://github.com/laravel/framework/blob/8.x/CHANGELOG-8.x.md#v8150-2020-11-17
     */
    public function failsIfCacheIsNotLockProvider()
    {
        $this->markTestSkipped('Laravel file cache store now supports locks, since v8.15');

        $this->expectException(StoreException::class);

        /** @var CacheStore $store */
        $store = $this->makeStoreWithService(CacheStore::class, [
            'cache-store' => 'file'
        ]);

        $store->getCache();
    }
}
