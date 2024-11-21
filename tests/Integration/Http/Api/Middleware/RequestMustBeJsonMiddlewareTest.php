<?php

namespace Aedart\Tests\Integration\Http\Api\Middleware;

use Aedart\Http\Api\Middleware\RequestMustBeJson;
use Aedart\Tests\TestCases\Http\ApiResourcesTestCase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * RequestMustBeJsonMiddlewareTest
 *
 * @group http-api
 * @group http-api-middleware
 * @group http-api-middleware-must-be-json
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Middleware
 */
class RequestMustBeJsonMiddlewareTest extends ApiResourcesTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function canProcessesDataSubmissionRequest(): void
    {
        $request = new Request();
        $request->setMethod('POST');
        $request->headers->set('CONTENT_TYPE', 'application/json');
        $request->headers->set('ACCEPT', 'application/json');

        /** @var Response $response */
        $response = (new RequestMustBeJson())->handle($request, function () {
            return new Response();
        });

        $this->assertTrue($response->isOk());
    }

    /**
     * @test
     *
     * @return void
     */
    public function canProcessesDataRetrievalRequest(): void
    {
        $request = new Request();
        $request->setMethod('GET');
        $request->headers->set('ACCEPT', 'application/json');

        /** @var Response $response */
        $response = (new RequestMustBeJson())->handle($request, function () {
            return new Response();
        });

        $this->assertTrue($response->isOk());
    }

    /**
     * @test
     *
     * @return void
     */
    public function rejectsWhenContentTypeHeaderNotValid(): void
    {
        $this->expectException(BadRequestHttpException::class);
        $this->expectExceptionMessage('Invalid content-type header. Request can only process JSON content type, e.g. application/json');

        $request = new Request();
        $request->setMethod('POST');
        $request->headers->set('CONTENT_TYPE', 'text/plain');

        /** @var Response $response */
        (new RequestMustBeJson())->handle($request, function () {
            return new Response();
        });
    }

    /**
     * @test
     *
     * @return void
     */
    public function rejectsWhenContentTypeMissingForContentModificationMethod(): void
    {
        $this->expectException(BadRequestHttpException::class);
        $this->expectExceptionMessage('Invalid content-type header. Request can only process JSON content type, e.g. application/json');

        $request = new Request();
        $request->setMethod('POST');
        // No Content-Type header here - should be rejected.

        /** @var Response $response */
        (new RequestMustBeJson())->handle($request, function () {
            return new Response();
        });
    }

    /**
     * @test
     *
     * @return void
     */
    public function rejectsWhenAcceptHeaderNotValid(): void
    {
        $this->expectException(BadRequestHttpException::class);
        $this->expectExceptionMessage('Invalid accept header. Only JSON response can be delivered, e.g. application/json');

        $request = new Request();
        $request->setMethod('GET');
        $request->headers->set('ACCEPT', 'text/plain');

        /** @var Response $response */
        (new RequestMustBeJson())->handle($request, function () {
            return new Response();
        });
    }
}
