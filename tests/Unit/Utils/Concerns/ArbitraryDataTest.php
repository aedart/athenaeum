<?php

namespace Aedart\Tests\Unit\Utils\Concerns;

use Aedart\Contracts\Utils\HasArbitraryData;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Concerns\ArbitraryData;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * ArbitraryDataTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Concerns
 */
#[Group(
    'utils',
    'arbitrary-data',
)]
class ArbitraryDataTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new arbitrary data store instance
     *
     * @param  array  $items  [optional]
     *
     * @return HasArbitraryData
     */
    public function makeStore(array $items = []): HasArbitraryData
    {
        $store = new class() implements HasArbitraryData {
            use ArbitraryData;

            public function __construct(array $items = [])
            {
                $this->arbitraryDataStore = $items;
            }
        };

        return new $store($items);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @return void
     */
    #[Test]
    public function canSetAndObtainValue(): void
    {
        $store = $this->makeStore();

        $key = 'my.item.a';
        $value = 1234;

        // --------------------------------------------------------------- //

        $store->set($key, $value);
        $result = $store->get($key);

        // --------------------------------------------------------------- //

        $this->assertTrue($store->has($key), 'Key does not exist');
        $this->assertTrue(isset($store[$key]), 'Key not set');

        $this->assertFalse($store->isEmpty(), 'store is empty failed');
        $this->assertTrue($store->isNotEmpty(), 'store is not empty failed');

        $this->assertSame($value, $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function canSetAndObtainViaArrayAccess(): void
    {
        $store = $this->makeStore();

        $key = 'my.item.a';
        $value = 1234;

        // --------------------------------------------------------------- //

        $store[$key] = $value;
        $result = $store[$key];

        // --------------------------------------------------------------- //

        $this->assertTrue($store->has($key), 'Key does not exist');
        $this->assertTrue(isset($store[$key]), 'Key not set');

        $this->assertFalse($store->isEmpty(), 'store is empty failed');
        $this->assertTrue($store->isNotEmpty(), 'store is not empty failed');

        $this->assertSame($value, $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function canRemoveItems(): void
    {
        $store = $this->makeStore([
            'a' => 'a',
            'b' => 'b',
            'c' => [
                'x' => 1324,
                'y' => 4321
            ],
        ]);

        $this->assertTrue($store->delete('c.y'), 'item not removed');
        $this->assertFalse($store->has('c.y'), 'item still exists in store');

        unset($store['c.x']);
        $this->assertFalse($store->has('c.x'), 'failed removing via array access');
    }

    /**
     * @return void
     */
    #[Test]
    public function canClearItems(): void
    {
        $store = $this->makeStore([
            'a' => 'a',
            'b' => 'b',
            'c' => [
                'x' => 1324,
                'y' => 4321
            ],
        ]);

        $store->clear();

        $this->assertTrue($store->isEmpty(), 'store is empty failed');
        $this->assertFalse($store->isNotEmpty(), 'store is not empty failed');
    }

    /**
     * @return void
     */
    #[Test]
    public function canObtainAllItems(): void
    {
        $expected = [
            'a' => 'a',
            'b' => 'b',
            'c' => 'c'
        ];

        $store = $this->makeStore($expected);

        $result = $store->all();

        foreach ($result as $key => $value) {
            $this->assertArrayHasKey($key, $expected);
            $this->assertSame($expected[$key], $value);
        }
    }
}
