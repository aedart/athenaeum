<?php

namespace Aedart\Tests\Integration\Http\Api\Resources;

use Aedart\Contracts\ETags\Exceptions\ETagGeneratorException;
use Aedart\Contracts\Utils\Dates\DateTimeFormats;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\User;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\UserResource;
use Aedart\Tests\TestCases\Http\ApiResourcesTestCase;
use Codeception\Attribute\Group;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Test;

/**
 * HttpCachingTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Resources
 */
#[Group(
    'http-api',
    'api-resource',
    'api-resource-http-caching',
)]
class HttpCachingTest extends ApiResourcesTestCase
{
    /**
     * @return void
     */
    #[Test]
    public function appliesCacheHeadersToResponse(): void
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

    /**
     * @return void
     *
     * @throws ETagGeneratorException
     */
    #[Test]
    public function canSetResourceEtag(): void
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

        $etag = '"1234"';
        $resource->withEtag($etag);

        // -------------------------------------------------------------------- //

        $result = $resource->getEtag();
        $this->assertSame($etag, $result);

        $headers = $resource->toResponse(Request::create('something'))->headers;
        $this->assertTrue($headers->has('ETag'), 'ETag header not set');
        $this->assertSame($etag, $headers->get('ETag'), 'Incorrect ETag in response headers');
    }

    /**
     * @return void
     *
     * @throws ETagGeneratorException
     */
    #[Test]
    public function canRemoveResourceEtagFromHeaders(): void
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
            ->withoutEtag()
            ->toResponse(Request::create('something'));

        ConsoleDebugger::output((string) $response);

        // -------------------------------------------------------------------- //

        $headers = $response->headers;

        $this->assertFalse($headers->has('ETag'), 'ETag header was not removed');
    }

    /**
     * @return void
     *
     * @throws ETagGeneratorException
     */
    #[Test]
    public function canSetResourceLastModifiedDate(): void
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

        $lastModified = now();
        $resource->withLastModifiedDate($lastModified);

        // -------------------------------------------------------------------- //

        $result = $resource->getLastModifiedDate();
        $this->assertSame($lastModified, $result);

        $headers = $resource->toResponse(Request::create('something'))->headers;
        $this->assertTrue($headers->has('Last-Modified'), 'last-Modified header not set');
        $this->assertSame($lastModified->format(DateTimeFormats::RFC9110), $headers->get('Last-Modified'), 'Incorrect last-Modified in response headers');
    }

    /**
     * @return void
     *
     * @throws ETagGeneratorException
     */
    #[Test]
    public function canRemoveResourceLastModifiedDateFromHeaders(): void
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
            ->withoutLastModifiedDate()
            ->toResponse(Request::create('something'));

        ConsoleDebugger::output((string) $response);

        // -------------------------------------------------------------------- //

        $headers = $response->headers;

        $this->assertFalse($headers->has('Last-Modified'), 'Last-Modified header was not removed');
    }
}
