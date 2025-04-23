<?php

namespace Aedart\Tests\Integration\Http\Api\Resources;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Game;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\GameResource;
use Aedart\Tests\TestCases\Http\ApiResourcesTestCase;
use Aedart\Utils\Json;
use Codeception\Attribute\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use JsonException;
use PHPUnit\Framework\Attributes\Test;

/**
 * CollectionTest
 *
 * @group http-api
 * @group api-resource
 * @group api-resource-collection
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Resources
 */
#[Group(
    'http-api',
    'api-resource',
    'api-resource-collection',
)]
class CollectionTest extends ApiResourcesTestCase
{
    /**
     * When true, migrations for this test-case will
     * be installed.
     *
     * @var bool
     */
    protected bool $installMigrations = true;

    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * @inheritDoc
     */
    protected function _before()
    {
        parent::_before();

        // Create a few dummy records in the database...
        Game::factory()
            ->count(8)
            ->create();

        // ------------------------------------------------------------------ //
        // Prerequisites - we need a route to the resource, with appropriate
        // name...

        Route::get('/games/{id}', function () {
            return response()->json();
        })->name('games.show');

        // Refresh name lookup or test could fail...
        Route::getRoutes()->refreshNameLookups();
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canFormatCollection(): void
    {
        $records = Game::query()
            ->paginate(3);

        // -------------------------------------------------------------- //

        $resource = GameResource::collection($records);

        $result = $resource->toArray(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $expectedKeys = [
            'slug',
            'name',
            'description',
            'created_at',
            'updated_at',
            'deleted',
            'deleted_at',
            // 'meta' // Tested separately
        ];

        foreach ($result as $index => $entry) {
            foreach ($expectedKeys as $key) {
                $this->assertArrayHasKey($key, $entry, "{$key} does not exist in entry at index: {$index}");
            }

            // Ensure has correct meta...
            $this->assertArrayHasKey('meta', $entry, "meta does not exist in entry at index: {$index}");
            $meta = $entry['meta'];

            $this->assertArrayHasKey('type', $meta, "type does not exist in meta, in entry at index: {$index}");
            $this->assertNotEmpty($meta['type'], "meta type is empty, in entry at index: {$index}");

            $this->assertArrayHasKey('self', $meta, "type does not exist in meta, in entry at index: {$index}");
            $this->assertNotEmpty($meta['self'], "meta self link is empty, in entry at index: {$index}");
        }
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws JsonException
     */
    #[Test]
    public function canReturnPaginatedResponse(): void
    {
        $records = Game::query()
            ->paginate(3, [ '*' ], 'page', 2);

        // -------------------------------------------------------------- //

        $resource = GameResource::collection($records);

        $response = $resource->toResponse(Request::create('something'));

        ConsoleDebugger::output((string) $response);

        // -------------------------------------------------------------- //

        $content = Json::decode($response->getContent(), true);
        ConsoleDebugger::output($content);

        $this->assertArrayHasKey('data', $content, 'No data provided');
        $this->assertCount(3, $content['data'], 'Invalid results in response');

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('meta', $content, 'Response does not contain meta');
        $meta = $content['meta'];

        $expectedKeys = [
            'first',
            'last',
            'prev',
            'next',
            'current_page',
            'from',
            'last_page',
            'per_page',
            'to',
            'total'
        ];

        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $meta, "{$key} does not exist in meta");
            $this->assertNotEmpty($meta[$key], "{$key} is empty in meta");
        }
    }
}
