<?php

namespace Aedart\Tests\Integration\ETags\Preconditions;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\ETags\Requests\ShowUserRequest;
use Aedart\Tests\TestCases\ETags\PreconditionsTestCase;
use Aedart\Utils\Json;
use Codeception\Attribute\Group;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Test;
use Teapot\StatusCode\All as HttpStatus;

/**
 * FullRequestTest
 *
 * @group etags
 * @group preconditions
 * @group preconditions-full-request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\ETags\Preconditions
 */
#[Group(
    'etags',
    'preconditions',
    'preconditions-full-request'
)]
class FullRequestTest extends PreconditionsTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canEvaluateAndProcessRequest(): void
    {
        Route::get('/user/{id}', function (ShowUserRequest $request) {
            $resource = $request->resource;

            return response()
                ->json($resource->data()->toArray())
                ->withCache(
                    etag: $resource->etag(),
                    lastModified: $resource->lastModifiedDate(),
                    private: true
                );
        })->name('users.show');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------ //

        // First request, without any preconditions...
        $url = route('users.show', [ 'id' => 42 ]);
        $responseA = $this
            ->get($url)
            ->assertOk();

        $headersA = $responseA->headers;
        $content = Json::decode($responseA->getContent(), true);

        ConsoleDebugger::output($headersA->all());
        ConsoleDebugger::output($content);

        // ------------------------------------------------------------ //

        // Second request, with If-None-Match and If-Modified-Since...
        // The If-None-Match "should" result in 304 Not Modified
        $responseB = $this
            ->get($url, [
                'If-None-Match' => $headersA->get('etag'),
                'If-Modified-Since' => $headersA->get('Last-Modified')
            ])
            ->assertStatus(HttpStatus::NOT_MODIFIED);

        $headersB = $responseB->headers;
        ConsoleDebugger::output($headersB->all());

        // ------------------------------------------------------------ //

        // Another request, but with only and If-Modified-Since...
        $responseC = $this
            ->get($url, [
                'If-Modified-Since' => $headersA->get('Last-Modified')
            ])
            ->assertStatus(HttpStatus::NOT_MODIFIED);

        $headersC = $responseC->headers;
        ConsoleDebugger::output($headersC->all());

        // ------------------------------------------------------------ //

        // Last request, using If-Match, but a "wrong" etag value to force
        // a precondition failed...
        $responseD = $this
            ->get($url, [
                'If-Match' => 'W/"1234"'
            ])
            ->assertStatus(HttpStatus::PRECONDITION_FAILED);

        $headersD = $responseD->headers;
        ConsoleDebugger::output($headersD->all());
    }
}
