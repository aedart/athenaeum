<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Clients\Middleware;

use Aedart\Contracts\Http\Clients\Middleware;
use Aedart\Contracts\Http\Clients\Requests\Handler;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Dummy Middleware
 *
 * FOR TESTING ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Clients\Middleware
 */
class DummyMiddleware implements Middleware
{
    /**
     * State whether or not this middleware
     * has been invoked or not
     *
     * @var bool
     */
    protected bool $invoked = false;

    /**
     * @inheritDoc
     */
    public function process(RequestInterface $request, Handler $handler): ResponseInterface
    {
        $this->invoked = true;
        ConsoleDebugger::output('dummy middleware invoked');

        return $handler->handle($request);
    }

    /**
     * Determine whether or not this middleware has been invoked.
     *
     * @return bool
     */
    public function hasBeenInvoked(): bool
    {
        return $this->invoked;
    }
}
