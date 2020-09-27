<?php

namespace Aedart\Tests\Unit\Http\Clients\Requests\Handlers;

use Aedart\Contracts\Http\Clients\Middleware;
use Aedart\Http\Clients\Requests\Handlers\QueueHandler;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Tests\Helpers\Dummies\Http\Clients\Middleware\DummyMiddleware;
use Aedart\Tests\Helpers\Dummies\Http\Clients\Requests\Handlers\DummyHandler;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

/**
 * QueueHandlerTest
 *
 * @group http-clients
 * @group http-clients-middleware
 * @group http-clients-queue-handler
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Http\Clients\Requests\Handlers
 */
class QueueHandlerTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new Queue Handler instance
     *
     * @return QueueHandler
     */
    public function makeQueueHandler(): QueueHandler
    {
        $fallback = new DummyHandler();

        return new QueueHandler($fallback);
    }

    /**
     * Creates new middleware instance
     *
     * @return Middleware|DummyMiddleware
     */
    public function makeMiddleware(): Middleware
    {
        return new DummyMiddleware();
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     */
    public function canProcessMiddleware()
    {
        // ------------------------------------------------------- //
        // Prepare
        $request = new Request('post', '/users');

        $a = $this->makeMiddleware();
        $b = $this->makeMiddleware();
        $c = $this->makeMiddleware();

        $middlewareList = [ $a, $b, $c ];

        $handler = $this->makeQueueHandler();
        $handler->addMultiple($middlewareList);

        // ------------------------------------------------------- //
        // Handle request

        $response = $handler->handle($request);

        // ------------------------------------------------------- //
        // Assert
        $this->assertInstanceOf(ResponseInterface::class, $response);
        foreach ($middlewareList as $middleware) {
            $this->assertTrue($middleware->hasBeenInvoked(), 'Middleware not invoked');
        }
    }
}
