<?php

namespace Aedart\Tests\Integration\Redmine\Collections;

use Aedart\Redmine\Collections\Collection;
use Aedart\Tests\Helpers\Dummies\Redmine\DummyResource;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * CollectionsTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Collections
 */
#[Group(
    'redmine',
    'redmine-collections',
)]
class CollectionsTest extends RedmineTestCase
{
    /**
     * @throws \Throwable
     */
    #[Test]
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
     * @throws \Throwable
     */
    #[Test]
    public function hasResourceClassDefined()
    {
        $payload = $this->makeDummyList();

        $collection = Collection::fromResponsePayload($payload, new DummyResource());

        $this->assertSame(DummyResource::class, $collection->resourceClass);
    }

    /**
     * @throws \Throwable
     */
    #[Test]
    public function canFilterResourcesFromCollection()
    {
        // This test ensures that the Redmine Resource (DTO)'s
        // properties are accessible by Laravel's collection and
        // thus allows filtering.

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
