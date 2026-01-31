<?php

namespace Aedart\Tests\Integration\Http\Api\Resources;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Game;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\GameResource;
use Aedart\Tests\TestCases\Http\ApiResourcesTestCase;
use Codeception\Attribute\Group;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Attributes\Test;

/**
 * TimestampsTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Resources
 */
#[Group(
    'http-api',
    'api-resource',
    'api-resource-timestamps',
)]
class TimestampsTest extends ApiResourcesTestCase
{
    /**
     * @return void
     *
     * @throws ValidationException
     */
    #[Test]
    public function addsTimestampsToPayload(): void
    {
        $faker = $this->getFaker();

        $model = new Game([
            'slug' => $faker->slug(3),
            'name' => $faker->text(25),
            'description' => $faker->realText(100),
            'created_at' => now()->subDays($faker->randomDigitNotNull),
            'updated_at' => now()->subMinutes($faker->randomDigitNotNull),
            'deleted_at' => now()
        ]);

        $resource = new GameResource($model);

        // -------------------------------------------------------------------- //

        $payload = $resource->toArray(Request::create('something'));

        ConsoleDebugger::output($payload);

        // -------------------------------------------------------------------- //

        $this->assertArrayHasKey('created_at', $payload);
        $this->assertNotEmpty($payload['created_at'], 'Empty created at property');

        $this->assertArrayHasKey('updated_at', $payload);
        $this->assertNotEmpty($payload['updated_at'], 'Empty updated at property');

        $this->assertArrayHasKey('deleted_at', $payload);
        $this->assertNotEmpty($payload['deleted_at'], 'Empty deleted at property');

        $this->assertArrayHasKey('deleted', $payload);
        $this->assertNotEmpty($payload['deleted'], 'Empty deleted property');
        $this->assertTrue($payload['deleted'], 'Deleted state should be true');
    }
}
