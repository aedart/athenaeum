<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Clients\Requests\Handlers;

use Aedart\Contracts\Http\Clients\Requests\Handler;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Teapot\StatusCode\Http;

/**
 * Dummy Handler
 *
 * FOR TESTING ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Clients\Requests\Handlers
 */
class DummyHandler implements Handler
{
    /**
     * @inheritDoc
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        return new Response(Http::OK);
    }
}
