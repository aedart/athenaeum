<?php

namespace Aedart\Tests\Integration\Http\Api\Resources;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\User;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\UserResource;
use Aedart\Tests\TestCases\Http\ApiResourcesTestCase;
use Illuminate\Http\Request;

/**
 * HttpCachingTest
 *
 * @group http-api
 * @group api-resource
 * @group api-resource-http-caching
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Resources
 */
class HttpCachingTest extends ApiResourcesTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function addsHttpCacheHeaders(): void
    {
        $faker = $this->getFaker();

        $model = new User([
            'id' => $faker->randomNumber(3),
            'name' => $faker->name(),
            'created_at' => now()->subDays($faker->randomDigitNotNull),
            'updated_at' => now()->subMinutes($faker->randomDigitNotNull),
        ]);

        $resource = new UserResource($model);

        // -------------------------------------------------------------------- //

        $response = $resource
            ->withCache()
            ->toResponse(Request::create('something'));

        ConsoleDebugger::output((string) $response);

        // -------------------------------------------------------------------- //

        $headers = $response->headers;

        $this->assertTrue($headers->has('Cache-Control'), 'Cache-Control header not set');
        $this->assertNotEmpty($headers->get('Cache-Control'), 'Cache-Control is empty!');

        $this->assertTrue($headers->has('ETag'), 'ETag header not set');
        $this->assertNotEmpty($headers->get('ETag'), 'ETag is empty!');

        $this->assertTrue($headers->has('Last-Modified'), 'Last-Modified header not set');
        $this->assertNotEmpty($headers->get('Last-Modified'), 'Last-Modified is empty!');
    }
}