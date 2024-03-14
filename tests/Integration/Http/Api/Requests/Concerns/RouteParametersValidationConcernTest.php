<?php

namespace Aedart\Tests\Integration\Http\Api\Requests\Concerns;

use Aedart\Testing\Helpers\Http\Response;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Address;
use Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Addresses\ShowAddressRequest;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\AddressResource;
use Aedart\Tests\TestCases\Http\ApiResourceRequestsTestCase;
use Illuminate\Support\Facades\Route;
use Illuminate\Testing\Fluent\AssertableJson;
use JsonException;

/**
 * RouteParametersValidationConcernTest
 *
 * @group http-api
 * @group api-resource
 * @group api-resource-request-concerns
 * @group route-parameters-validation
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Requests\Concerns
 */
class RouteParametersValidationConcernTest extends ApiResourceRequestsTestCase
{
    /**
     * @test
     *
     * @return void
     *
     * @throws JsonException
     */
    public function passesValidRouteParameter(): void
    {
        /** @var Address $expected */
        $expected = Address::factory()
            ->create();

        // ------------------------------------------------------------------ //

        Route::get('/addresses/{address}', function (ShowAddressRequest $request) {
            return AddressResource::make($request->address);
        })->name('addresses.show');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        $url = route('addresses.show', $expected->getKey());
        $response = $this
            ->getJson($url)
            ->assertOk();

        // If we reached this point, it means that validation should had passed...
        Response::decode($response);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws JsonException
     */
    public function failsInvalidRouteParameter(): void
    {
        Address::factory()
            ->create();

        // ------------------------------------------------------------------ //

        Route::get('/addresses/{address}', function (ShowAddressRequest $request) {
            return AddressResource::make($request->address);
        })->name('addresses.show');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------ //

        // Notice that given format of route param is a string, which should not
        // be accepted...
        $url = route('addresses.show', 'undefined');

        $response = $this
            ->getJson($url)
            ->assertUnprocessable()
            ->assertJson(
                fn (AssertableJson $json) =>
                $json
                    ->has('errors.address')
                    ->etc()
            );

        Response::decode($response);
    }
}
