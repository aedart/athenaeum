<?php

namespace Aedart\Tests\Integration\Redmine\Collections;

use Aedart\Redmine\Collections\Collection;
use Aedart\Tests\Helpers\Dummies\Redmine\DummyResource;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;

/**
 * CollectionsTest
 *
 * @group redmine
 * @group redmine-collections
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Redmine\Collections
 */
class CollectionsTest extends RedmineTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Makes a new dummy resource payload
     *
     * @param array $data [optional]
     *
     * @return array
     */
    public function makeDummyPayload(array $data = []): array
    {
        $faker = $this->getFaker();

        return array_merge([
            'id' => $faker->unique()->randomNumber(4, true),
            'name' => $faker->name
        ], $data);
    }

    /**
     * Returns a list of dummies...
     *
     * @param int $amount [optional]
     *
     * @return array
     */
    public function makeDummyList(int $amount = 3): array
    {
        $name = (new DummyResource())->resourceName();

        $list = [];
        while ($amount--) {
            $list[] = $this->makeDummyPayload();
        }

        return [
            $name => $list
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function canCreateFromResponsePayload()
    {
        $payload = $this->makeDummyList(5);

        $collection = Collection::fromResponsePayload($payload, new DummyResource());

        $this->assertNotEmpty($collection, 'Empty collection returned');

        // -------------------------------------------- //

        foreach ($collection as $resource) {
            $this->assertInstanceOf(DummyResource::class, $resource, 'Invalid resource in collection');
        }
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function hasResourceClassDefined()
    {
        $payload = $this->makeDummyList();

        $collection = Collection::fromResponsePayload($payload, new DummyResource());

        $this->assertSame(DummyResource::class, $collection->resourceClass);
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function canFilterResourcesFromCollection()
    {
        $name = (new DummyResource())->resourceName();
        $payload = [
            $name => [
                $this->makeDummyPayload([ 'name' => 'a' ]),
                $this->makeDummyPayload([ 'name' => 'b' ]),
                $this->makeDummyPayload([ 'name' => 'c' ]),
            ]
        ];

        $collection = Collection::fromResponsePayload($payload, new DummyResource());

        $filtered = $collection->where('name', 'a')->first();

        $this->assertNotNull($filtered);
        $this->assertInstanceOf(DummyResource::class, $filtered);
        $this->assertSame('a', $filtered->name);
    }
}
