<?php

namespace Aedart\Tests\Integration\Http\Api\Responses;

use Aedart\Http\Api\Responses\ApiErrorResponse;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\ApiResourcesTestCase;
use Aedart\Utils\Json;
use Codeception\Attribute\Group;
use Illuminate\Http\Request;
use InvalidArgumentException;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Teapot\StatusCode\All as HttpStatus;

/**
 * ApiErrorResponseTest
 *
 * @group http-api
 * @group api-error-response
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Responses
 */
#[Group(
    'http-api',
    'api-error-response',
)]
class ApiErrorResponseTest extends ApiResourcesTestCase
{
    /**
     * @test
     *
     * @return void
     *
     * @throws JsonException
     */
    #[Test]
    public function canMakeResponseForException(): void
    {
        $ex = new InvalidArgumentException('test');

        $request = Request::create('something');
        $response = ApiErrorResponse::makeFor($ex, null, $request);

        // --------------------------------------------------------------- //

        $content = Json::decode($response->getContent(), true);
        ConsoleDebugger::output($content);

        // --------------------------------------------------------------- //

        $this->assertSame(HttpStatus::INTERNAL_SERVER_ERROR, $response->status(), 'Incorrect status');
        $this->assertArrayHasKey('status', $content);
        $this->assertArrayHasKey('message', $content);
        $this->assertArrayHasKey('source', $content);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws JsonException
     */
    #[Test]
    public function addsStackTraceWhenAppInDebugMode(): void
    {
        // Enable application's debug state
        $this->getConfig()->set('app.debug', true);

        // --------------------------------------------------------------- //

        $ex = new InvalidArgumentException('test');

        $request = Request::create('something');
        $response = ApiErrorResponse::makeFor($ex, null, $request);

        // --------------------------------------------------------------- //

        $content = Json::decode($response->getContent(), true);
        ConsoleDebugger::output($content);

        // --------------------------------------------------------------- //

        $this->assertArrayHasKey('source', $content);

        $source = $content['source'];
        $this->assertArrayHasKey('message', $source);
        $this->assertNotEmpty($source['message'], 'No exception message');

        $this->assertArrayHasKey('exception', $source);
        $this->assertNotEmpty($source['exception'], 'No exception class');

        $this->assertArrayHasKey('file', $source);
        $this->assertNotEmpty($source['file'], 'No file defined');

        $this->assertArrayHasKey('line', $source);
        $this->assertNotEmpty($source['line'], 'No file line set');

        $this->assertArrayHasKey('trace', $source);
        $this->assertNotEmpty($source['trace'], 'No stack trace added');
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function usesHttpExceptionHeaders(): void
    {
        $ex = new NotFoundHttpException('record was not found');

        $request = Request::create('something');
        $response = ApiErrorResponse::makeFor($ex, null, $request);

        // --------------------------------------------------------------- //

        $this->assertSame(HttpStatus::NOT_FOUND, $response->status(), 'Incorrect status');
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function usesSpecifiedHttpStatusWhenGiven(): void
    {
        $ex = new NotFoundHttpException('record was not found');

        $request = Request::create('something');
        $expected = HttpStatus::NOT_MODIFIED;
        $response = ApiErrorResponse::makeFor($ex, $expected, $request);

        // --------------------------------------------------------------- //

        $this->assertSame($expected, $response->status(), 'Incorrect status');
    }
}
