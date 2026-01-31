<?php

namespace Aedart\Tests\Integration\Http\Api\Resources\Relations;

use Aedart\Http\Api\Resources\ApiResource;
use Aedart\Http\Api\Resources\Relations\Exceptions\RelationReferenceException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Game;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Owner;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\GameResource;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\OwnerResource;
use Aedart\Tests\TestCases\Http\ApiResourcesTestCase;
use Codeception\Attribute\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Test;

/**
 * BelongsToReferenceTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Resources\Relations
 */
#[Group(
    'http-api',
    'api-resource',
    'api-resource-relations',
    'api-resource-relations-references',
    'api-resource-relation-belongs-to',
)]
class BelongsToReferenceTest extends ApiResourcesTestCase
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

        // Register Owner Resource
        $this->getApiResourceRegistrar()->register([
            Owner::class => OwnerResource::class
        ]);

        // ------------------------------------------------------------------ //
        // Prerequisites - we need a route to the resource, with appropriate
        // name...

        Route::get('/games/{id}', function () {
            return response()->json();
        })->name('games.show');

        Route::get('/owners/{id}', function () {
            return response()->json();
        })->name('owners.show');

        // Refresh name lookup or test could fail...
        Route::getRoutes()->refreshNameLookups();
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @return void
     */
    #[Test]
    public function defaultsToNullWhenRelationNotLoaded(): void
    {
        $record = Game::query()
            ->inRandomOrder()
            ->first();

        // -------------------------------------------------------------- //

        $resource = new GameResource($record);

        $result = $resource->resolve(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('owner', $result);
        $this->assertNull($result['owner']);
    }

    /**
     * @return void
     */
    #[Test]
    public function returnsDefaultValueForRelation(): void
    {
        $record = Game::query()
            ->inRandomOrder()
            ->first();

        // -------------------------------------------------------------- //

        $default = 'my-default-value';
        $resource = (new GameResource($record))
            ->format(function (array $payload) use ($default) {
                $payload['owner'] = $payload['owner']->defaultTo($default);

                return $payload;
            });

        $result = $resource->resolve(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('owner', $result);
        $this->assertSame($default, $result['owner']);
    }

    /**
     * @return void
     */
    #[Test]
    public function returnsCallbackValueForRelation(): void
    {
        $record = Game::query()
            ->inRandomOrder()
            ->first();

        // -------------------------------------------------------------- //

        $default = 'value-from-callback';
        $resource = (new GameResource($record))
            ->format(function (array $payload) use ($default) {
                $payload['owner'] = $payload['owner']->defaultTo(fn () => $default);

                return $payload;
            });

        $result = $resource->resolve(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('owner', $result);
        $this->assertSame($default, $result['owner']);
    }

    /**
     * @return void
     */
    #[Test]
    public function canDisplayRelationIdentifier(): void
    {
        /** @var Game $record */
        $record = Game::query()
            ->with([ 'owner' ])
            ->inRandomOrder()
            ->first();

        // -------------------------------------------------------------- //

        $resource = (new GameResource($record))
            ->format(function (array $payload, $request, ApiResource $resource) {
                $payload['owner'] = $resource
                    ->belongsToReference('owner');

                return $payload;
            });

        $result = $resource->resolve(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('owner', $result);

        $owner = $result['owner'];
        $this->assertArrayHasKey('name', $owner);
        $this->assertSame($record->owner->name, $owner['name']);
    }

    /**
     * @return void
     */
    #[Test]
    public function canUseCustomPrimaryKey(): void
    {
        /** @var Game $record */
        $record = Game::query()
            ->with([ 'owner' ])
            ->inRandomOrder()
            ->first();

        // -------------------------------------------------------------- //

        $resource = (new GameResource($record))
            ->format(function (array $payload, $request, ApiResource $resource) {
                $payload['owner'] = $resource
                    ->belongsToReference('owner')
                    ->usePrimaryKey('id');

                return $payload;
            });

        $result = $resource->resolve(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('owner', $result);

        $owner = $result['owner'];
        $this->assertArrayHasKey('name', $owner);
        $this->assertSame($record->owner_id, $owner['name']);
    }

    /**
     * @return void
     */
    #[Test]
    public function canDisplayCustomIdentifierDisplayName(): void
    {
        /** @var Game $record */
        $record = Game::query()
            ->with([ 'owner' ])
            ->inRandomOrder()
            ->first();

        // -------------------------------------------------------------- //

        $resource = (new GameResource($record))
            ->format(function (array $payload, $request, ApiResource $resource) {
                $payload['owner'] = $resource
                    ->belongsToReference('owner')
                    ->usePrimaryKey('id')
                    ->setPrimaryKeyDisplayName('owner_id');

                return $payload;
            });

        $result = $resource->resolve(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('owner', $result);

        $owner = $result['owner'];
        $this->assertArrayHasKey('owner_id', $owner);
        $this->assertSame($record->owner_id, $owner['owner_id']);
    }

    /**
     * @return void
     */
    #[Test]
    public function canFormatAsRawIdentifier(): void
    {
        /** @var Game $record */
        $record = Game::query()
            ->with([ 'owner' ])
            ->inRandomOrder()
            ->first();

        // -------------------------------------------------------------- //

        $resource = (new GameResource($record))
            ->format(function (array $payload, $request, ApiResource $resource) {
                $payload['owner'] = $resource
                    ->belongsToReference('owner')
                    ->asRawIdentifier();

                return $payload;
            });

        $result = $resource->resolve(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('owner', $result);
        $this->assertSame($record->owner->name, $result['owner']);
    }

    /**
     * @return void
     */
    #[Test]
    public function canDisplayWithLabel(): void
    {
        /** @var Game $record */
        $record = Game::query()
            ->with([ 'owner' ])
            ->inRandomOrder()
            ->first();

        // -------------------------------------------------------------- //

        $resource = (new GameResource($record))
            ->format(function (array $payload, $request, ApiResource $resource) {
                $payload['owner'] = $resource
                    ->belongsToReference('owner')
                    ->withLabel('name')
                    ->setLabelDisplayName('label');

                return $payload;
            });

        $result = $resource->resolve(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('owner', $result);

        $owner = $result['owner'];
        $this->assertArrayHasKey('label', $owner);
        $this->assertSame($record->owner->name, $owner['label']);
    }

    /**
     * @return void
     */
    #[Test]
    public function canDisplayWithLabelCallback(): void
    {
        /** @var Game $record */
        $record = Game::query()
            ->with([ 'owner' ])
            ->inRandomOrder()
            ->first();

        // -------------------------------------------------------------- //

        $resource = (new GameResource($record))
            ->format(function (array $payload, $request, ApiResource $resource) {
                $payload['owner'] = $resource
                    ->belongsToReference('owner')
                    ->withLabel(function (Owner $model) {
                        $id = $model->getKey();
                        $name = $model->name;

                        return "{$id} | {$name}";
                    })
                    ->setLabelDisplayName('label');

                return $payload;
            });

        $result = $resource->resolve(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('owner', $result);

        $owner = $result['owner'];
        $this->assertArrayHasKey('label', $owner);

        $id = $record->owner->getKey();
        $name = $record->owner->name;
        $this->assertSame("{$id} | {$name}", $owner['label']);
    }

    /**
     * @return void
     */
    #[Test]
    public function failsShowingResourceTypeWhenNotRegistered(): void
    {
        $this->expectException(RelationReferenceException::class);

        // -------------------------------------------------------------- //
        // Unregister Api Resource for owner model

        $this->getApiResourceRegistrar()->forget(Owner::class);

        // -------------------------------------------------------------- //

        /** @var Game $record */
        $record = Game::query()
            ->with([ 'owner' ])
            ->inRandomOrder()
            ->first();

        // -------------------------------------------------------------- //

        $resource = (new GameResource($record))
            ->format(function (array $payload, $request, ApiResource $resource) {
                $payload['owner'] = $resource
                    ->belongsToReference('owner')
                    ->withResourceType();

                return $payload;
            });

        $resource->resolve(Request::create('something'));
    }

    /**
     * @return void
     */
    #[Test]
    public function canShowApiResourceType(): void
    {
        /** @var Game $record */
        $record = Game::query()
            ->with([ 'owner' ])
            ->inRandomOrder()
            ->first();

        // -------------------------------------------------------------- //

        $resource = (new GameResource($record))
            ->format(function (array $payload, $request, ApiResource $resource) {
                $payload['owner'] = $resource
                    ->belongsToReference('owner')
                    ->withResourceType()
                    ->setResourceTypeDisplayName('resource_name');

                return $payload;
            });

        $result = $resource->resolve(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('owner', $result);

        $owner = $result['owner'];
        $this->assertArrayHasKey('resource_name', $owner);
        $this->assertSame('owner', $owner['resource_name']);
    }

    /**
     * @return void
     */
    #[Test]
    public function canShowApiResourceTypeInPluralForm(): void
    {
        /** @var Game $record */
        $record = Game::query()
            ->with([ 'owner' ])
            ->inRandomOrder()
            ->first();

        // -------------------------------------------------------------- //

        $resource = (new GameResource($record))
            ->format(function (array $payload, $request, ApiResource $resource) {
                $payload['owner'] = $resource
                    ->belongsToReference('owner')
                    ->withResourceType(true, true);

                return $payload;
            });

        $result = $resource->resolve(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('owner', $result);

        $owner = $result['owner'];
        $this->assertArrayHasKey('type', $owner);
        $this->assertSame('owners', $owner['type']);
    }

    /**
     * @return void
     */
    #[Test]
    public function canShowSelfLink(): void
    {
        /** @var Game $record */
        $record = Game::query()
            ->with([ 'owner' ])
            ->inRandomOrder()
            ->first();

        // -------------------------------------------------------------- //

        $resource = (new GameResource($record))
            ->format(function (array $payload, $request, ApiResource $resource) {
                $payload['owner'] = $resource
                    ->belongsToReference('owner')
                    ->withSelfLink()
                    ->setSelfLinkDisplayName('link');

                return $payload;
            });

        $result = $resource->resolve(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('owner', $result);

        $owner = $result['owner'];
        $this->assertArrayHasKey('link', $owner);
        $this->assertNotEmpty($owner['link']);
    }

    /**
     * @return void
     */
    #[Test]
    public function appliesAdditionalCallback(): void
    {
        /** @var Game $record */
        $record = Game::query()
            ->with([ 'owner' ])
            ->inRandomOrder()
            ->first();

        // -------------------------------------------------------------- //

        $resource = (new GameResource($record))
            ->format(function (array $payload, $request, ApiResource $resource) {
                $payload['owner'] = $resource
                    ->belongsToReference('owner')
                    ->withAdditionalFormatting(function (array $output) {
                        $output['extra_info'] = true;

                        return $output;
                    });

                return $payload;
            });

        $result = $resource->resolve(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('owner', $result);

        $owner = $result['owner'];
        $this->assertArrayHasKey('extra_info', $owner);
        $this->assertTrue($owner['extra_info']);
    }
}
