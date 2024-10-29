<?php

namespace Aedart\Tests\Integration\Http\Api\Middleware;

use Aedart\Contracts\Http\Api\SelectedFieldsCollection;
use Aedart\Http\Api\Middleware\CaptureFieldsToSelect;
use Aedart\Support\Facades\IoCFacade;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\User;
use Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Users\ListUsersRequest;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\UserResource;
use Aedart\Tests\TestCases\Http\ApiResourcesTestCase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

/**
 * CaptureFieldsToSelectMiddlewareTest
 *
 * @group http-api
 * @group http-api-middleware
 * @group http-api-middleware-capture-select-fields
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Middleware
 */
class CaptureFieldsToSelectMiddlewareTest extends ApiResourcesTestCase
{
    /**
     * @test
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function doesNothingWhenNoSelectFieldsRequested(): void
    {
        $request = new Request();

        $result = null;

        /** @var Response $response */
        $response = (new CaptureFieldsToSelect())->handle($request, function () use (&$result) {
            $result = IoCFacade::tryMake(SelectedFieldsCollection::class);
            return new Response();
        });

        $this->assertTrue($response->isOk());
        $this->assertNull($result);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function capturesRequestedFields(): void
    {
        $requestedFields = [ 'alpha', 'beta', 'gamma' ];
        $request = new Request([ 'select' => implode(',', $requestedFields) ]);

        // ------------------------------------------------------------------------------------ //

        /** @var SelectedFieldsCollection|null $result */
        $result = null;

        /** @var Response $response */
        $response = (new CaptureFieldsToSelect())->handle($request, function () use (&$result) {
            $result = IoCFacade::tryMake(SelectedFieldsCollection::class);
            return new Response();
        });

        // ------------------------------------------------------------------------------------ //

        ConsoleDebugger::output($result);

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf(SelectedFieldsCollection::class, $result);
        $this->assertFalse($result->isEmpty(), 'Collection should not be empty');
        $this->assertTrue($result->isNotEmpty(), 'Collection should be "not empty"');
        $this->assertCount(count($requestedFields), $result);

        foreach ($requestedFields as $field) {
            $this->assertTrue($result->has($field), "{$field} was not captured");
        }
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function selectFieldsCollectionIsForgottenAfterRequest(): void
    {
        $requestedFields = [ 'alpha', 'beta', 'gamma' ];
        $request = new Request([ 'select' => implode(',', $requestedFields) ]);

        // ------------------------------------------------------------------------------------ //

        /** @var SelectedFieldsCollection|null $result */
        $result = null;

        /** @var Response $response */
        $response = (new CaptureFieldsToSelect())->handle($request, function () use (&$result) {
            $result = IoCFacade::tryMake(SelectedFieldsCollection::class);
            return new Response();
        });

        // ------------------------------------------------------------------------------------ //

        ConsoleDebugger::output($result);

        $this->assertTrue($response->isOk());
        $this->assertInstanceOf(SelectedFieldsCollection::class, $result);
        $this->assertTrue($result->isNotEmpty(), 'Collection should be "not empty"');
        $this->assertFalse(IoCFacade::bound(SelectedFieldsCollection::class));
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function failsWhenTooManyFieldsAreRequested(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The select field must not have more than 20 items.');

        $requestedFields = $this->getFaker()->words(21);
        $request = new Request([ 'select' => implode(',', $requestedFields) ]);

        (new CaptureFieldsToSelect())->handle($request, function () use (&$result) {
            $result = IoCFacade::tryMake(SelectedFieldsCollection::class);
            return new Response();
        });
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function failsWhenRequestedFieldNamesAreInvalid(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The select.2 may only contain letters, numbers, dashes, underscores and dots.');

        $requestedFields = [
            'alpha',
            'beta',
            'invalid field name'
        ];

        $request = new Request([ 'select' => implode(',', $requestedFields) ]);

        (new CaptureFieldsToSelect())->handle($request, function () {
            $result = IoCFacade::tryMake(SelectedFieldsCollection::class);
            return new Response();
        });
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function doesNotFailWhenFieldsRequestedAsAnArray(): void
    {
        // @see https://github.com/aedart/athenaeum/issues/197

        /** @var SelectedFieldsCollection|null $result */
        $result = null;

        Route::get('/users', function (Request $request) use(&$result) {
            $result = IoCFacade::tryMake(SelectedFieldsCollection::class);

            return new Response();
        })
            ->middleware(CaptureFieldsToSelect::class)
            ->name('users.index');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------------------------------ //

        $url = route('users.index') . '?select[0]=id&select[1]=user&select[2]=details';
        $this
            ->getJson($url)
            ->assertOk();

        // ------------------------------------------------------------------------------------ //

        ConsoleDebugger::output($result);

        $this->assertNotNull($result, 'no fields collection registered');
        $this->assertTrue($result->has('id'), '"id" field not available');
        $this->assertTrue($result->has('user'), '"user" field not available');
        $this->assertTrue($result->has('details'), '"details" field not available');
    }
}
