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
 * SelfLinkTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Resources
 */
#[Group(
    'http-api',
    'api-resource',
    'api-resource-self-link',
)]
class SelfLinkTest extends ApiResourcesTestCase
{
    /**
     * @return void
     */
    #[Test]
    public function canGenerateResourceRouteName(): void
    {
        $resource = new OwnerResource(null);

        $result = $resource->resourceRouteName();

        $this->assertSame('owners.show', $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function canMakeSelfLink(): void
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

        $result = $resource->makeSelfLink($request);
        $expected = '/owners/' . rawurlencode($name);

        ConsoleDebugger::output($result);

        $this->assertStringEndsWith($expected, $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function canMakeSelfLinkUsingCustomCallback(): void
    {
        $url = '/my-custom-resource-link';

        $resource = new OwnerResource(null);
        $resource->withSelfLink($url);

        // ------------------------------------------------------------------ //

        $result = $resource->makeSelfLink(
            Request::create('something')
        );

        ConsoleDebugger::output($result);

        $this->assertStringEndsWith($url, $result);
    }
}
