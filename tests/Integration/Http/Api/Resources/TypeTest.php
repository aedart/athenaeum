<?php

namespace Aedart\Tests\Integration\Http\Api\Resources;

use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\GameResource;
use Aedart\Tests\TestCases\Http\ApiResourcesTestCase;

/**
 * TypeTest
 *
 * @group http-api
 * @group api-resource
 * @group api-resource-type
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Resources
 */
class TypeTest extends ApiResourcesTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function canObtainResourceType(): void
    {
        $resource = new GameResource(null);

        $this->assertSame('game', $resource->type(), 'Incorrect type (singular form)');
        $this->assertSame('games', $resource->pluralType(), 'Incorrect type (plural form)');
    }

    /**
     * @test
     *
     * @return void
     */
    public function canMatchType(): void
    {
        $resource = new GameResource(null);

        $this->assertTrue($resource->matchesType('game'), 'Failed to match against type (singular form)');
        $this->assertTrue($resource->matchesType('games'), 'Failed to match against type (plural form)');
        $this->assertFalse($resource->matchesType('owner'), 'Should NOT have matched incorrect type');
    }
}
