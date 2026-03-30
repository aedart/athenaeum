<?php

namespace Aedart\Tests\Integration\Http\Api\Resources;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Owner;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\OwnerResource;
use Aedart\Tests\TestCases\Http\ApiResourcesTestCase;
use Codeception\Attribute\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Test;

/**
 * MetaTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Resources
 */
#[Group(
    'http-api',
    'api-resource',
    'api-resource-meta',
)]
class MetaTest extends ApiResourcesTestCase
{
    /**
     * @return void
     */
    #[Test]
    public function addsMetaToAdditionalData(): void
    {
        // ------------------------------------------------------------------ //
        // Prerequisites - we need a route to the resource, with appropriate
        // name...

        Route::get('/owners/{id}', function () {
            return response()->json();
        })->name('owners.show');

        // Refresh name lookup or test could fail...
        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        // Create dummy request
        $request = Request::create('something');

        // Create model with a name... Note: model is "sluggable"
        $name = $this->getFaker()->name;
        $model = new Owner([ 'name' => $name ]);

        $resource = new OwnerResource($model);

        // ------------------------------------------------------------------ //

        $data = $resource->with($request);

        ConsoleDebugger::output($data);

        // ------------------------------------------------------------------ //

        $this->assertArrayHasKey('meta', $data, 'No meta was added');
        $this->assertArrayHasKey('type', $data['meta'], 'Resource type not available in meta');
        $this->assertArrayHasKey('self', $data['meta'], 'Self link key not available in meta');
    }
}
