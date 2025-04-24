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
 * HasManyReferenceTest
 *
 * @group http-api
 * @group api-resource
 * @group api-resource-relations
 * @group api-resource-relation-references
 * @group api-resource-relation-has-many
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Resources\Relations
 */
#[Group(
    'http-api',
    'api-resource',
    'api-resource-relations',
    'api-resource-relations-references',
    'api-resource-relation-has-many',
)]
class HasManyReferenceTest extends ApiResourcesTestCase
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
        $address = Address::factory()
            ->create();

        Owner::factory()
            ->count(3)
            ->create([
                'address_id' => $address->getKey()
            ]);

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
     * @test
     *
     * @return void
     */
    #[Test]
    public function canFormatHasManyReference(): void
    {
        /** @var Address $record */
        $record = Address::query()
            ->with([ 'owners' ])
            ->first();

        // -------------------------------------------------------------- //

        $resource = (new AddressResource($record))
            ->format(function (array $payload, $request, ApiResource $resource) {
                // Manually add relation
                $payload['owners'] = $resource
                    ->hasManyReference('owners')
                    ->usePrimaryKey('id', 'ID')
                    ->withLabel(function (Owner $model) {
                        return $model->name;
                    })
                    ->withSelfLink()
                    ->withResourceType();

                return $payload;
            });

        $result = $resource->resolve(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('owners', $result);

        $ownersCollection = $record->owners;
        $owners = $result['owners'];

        $this->assertCount($record->owners->count(), $owners, 'Invalid amount of related models loaded');

        foreach ($owners as $index => $owner) {
            $this->assertArrayHasKey('ID', $owner);
            $this->assertSame($ownersCollection[$index]->getKey(), $owner['ID']);

            $this->assertArrayHasKey('name', $owner);
            $this->assertSame($ownersCollection[$index]->name, $owner['name']);

            $this->assertArrayHasKey('type', $owner);
            $this->assertSame('owner', $owner['type']);

            $this->assertArrayHasKey('self', $owner);
            $this->assertNotEmpty($owner['self']);
        }
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function returnsNullWhenNotRelationNotEagerLoaded(): void
    {
        /** @var Address $record */
        $record = Address::query()
            ->first();

        // -------------------------------------------------------------- //

        $resource = (new AddressResource($record))
            ->format(function (array $payload, $request, ApiResource $resource) {
                // Manually add relation
                $payload['owners'] = $resource
                    ->hasManyReference('owners');

                return $payload;
            });

        $result = $resource->resolve(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('owners', $result);
        $this->assertNull($result['owners']);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function returnsEmptyArrayWhenNoRelatedModelsExist(): void
    {
        /** @var Address $record */
        $record = Address::factory()
            ->create();

        $record->loadMissing([ 'owners' ]);

        // -------------------------------------------------------------- //

        $resource = (new AddressResource($record))
            ->format(function (array $payload, $request, ApiResource $resource) {
                // Manually add relation
                $payload['owners'] = $resource
                    ->hasManyReference('owners');

                return $payload;
            });

        $result = $resource->resolve(Request::create('something'));

        ConsoleDebugger::output($result);

        // -------------------------------------------------------------- //

        $this->assertArrayHasKey('owners', $result);
        $this->assertIsArray($result['owners']);
        $this->assertEmpty($result['owners']);
    }
}
