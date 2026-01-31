<?php

namespace Aedart\Tests\Integration\Http\Api\Resources\Relations;

use Aedart\Http\Api\Resources\ApiResource;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Address;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Game;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Owner;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\AddressResource;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\GameResource;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\OwnerResource;
use Aedart\Tests\TestCases\Http\ApiResourcesTestCase;
use Codeception\Attribute\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Test;

/**
 * NestedRelationsTest
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
    'api-resource-relation-nested-relations',
)]
class NestedRelationsTest extends ApiResourcesTestCase
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
            Owner::class => OwnerResource::class,
            Address::class => AddressResource::class
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

        Route::get('/addresses/{id}', function () {
            return response()->json();
        })->name('addresses.show');

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
    public function canLoadNestedRelations(): void
    {
        /** @var Game $record */
        $record = Game::query()
            ->with([ 'owner.address' ])
            ->inRandomOrder()
            ->first();

        // -------------------------------------------------------------- //

        $resource = (new GameResource($record))
            ->format(function (array $payload, $request, ApiResource $resource) {
                $payload['owner'] = $resource
                    ->belongsToReference('owner');

                // Manually add a nested relation to the output
                $payload['owner_address'] = $resource
                    ->belongsToReference('owner.address')
                    ->withLabel(function (Address $model) {
                        return $model->street;
                    })
                    ->withSelfLink()
                    ->withResourceType();

                return $payload;
            });

        $result = $resource->resolve(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('owner_address', $result);

        $addressModel = $record->owner->address;
        $address = $result['owner_address'];

        $this->assertArrayHasKey('id', $address);
        $this->assertSame($addressModel->getKey(), $address['id']);

        $this->assertArrayHasKey('name', $address);
        $this->assertSame($addressModel->street, $address['name']);

        $this->assertArrayHasKey('self', $address);
        $this->assertNotEmpty($address['self']);

        $this->assertArrayHasKey('type', $address);
        $this->assertSame('address', $address['type']);
    }
}
