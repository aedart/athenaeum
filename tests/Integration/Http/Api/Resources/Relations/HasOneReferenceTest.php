<?php

namespace Aedart\Tests\Integration\Http\Api\Resources\Relations;

use Aedart\Http\Api\Resources\ApiResource;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Address;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Owner;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\AddressResource;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\OwnerResource;
use Aedart\Tests\TestCases\Http\ApiResourcesTestCase;
use Codeception\Attribute\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Test;

/**
 * HasOneReferenceTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Resources\Relations
 */
#[Group(
    'http-api',
    'api-resource',
    'api-resource-relations',
    'api-resource-relations-references',
    'api-resource-relation-has-one',
)]
class HasOneReferenceTest extends ApiResourcesTestCase
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
        Owner::factory()
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
    public function canFormatHasOneReference(): void
    {
        /** @var Address $record */
        $record = Address::query()
            ->with([ 'owner' ])
            ->inRandomOrder()
            ->first();

        // -------------------------------------------------------------- //

        $resource = (new AddressResource($record))
            ->format(function (array $payload, $request, ApiResource $resource) {
                // Manually add relation
                $payload['owner'] = $resource
                    ->hasOneReference('owner')
                    ->usePrimaryKey('id', 'ID')
                    ->withLabel(function (Owner $model) {
                        return $model->name;
                    })
                    ->withSelfLink()
                    ->withResourceType(true, true);

                return $payload;
            });

        $result = $resource->resolve(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('owner', $result);


        $ownerModel = $record->owner;
        $owner = $result['owner'];

        $this->assertArrayHasKey('ID', $owner);
        $this->assertSame($ownerModel->getKey(), $owner['ID']);

        $this->assertArrayHasKey('name', $owner);
        $this->assertSame($ownerModel->name, $owner['name']);

        $this->assertArrayHasKey('type', $owner);
        $this->assertSame('owners', $owner['type']);

        $this->assertArrayHasKey('self', $owner);
        $this->assertNotEmpty($owner['self']);
    }
}
