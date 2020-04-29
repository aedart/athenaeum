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
     * @test
     */
    public function failsIfCacheIsNotLockProvider()
    {
        $this->expectException(StoreException::class);

        /** @var CacheStore $store */
        $store = $this->makeStoreWithService(CacheStore::class, [
            'cache-store' => 'file'
        ]);

        $store->getCacheStore();
    }
}
