<?php

namespace Aedart\Contracts\Http\Clients;

use Aedart\Contracts\Http\Clients\Requests\Handler;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Middleware that processes a request and response
 *
 * Heavily inspired by PSR-15: HTTP Server Request Handlers
 * @see https://www.php-fig.org/psr/psr-15/
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients
 */
interface Middleware
{
    /**
     * Process outgoing request and incoming response
     *
     * @param  RequestInterface  $request
     * @param  Handler  $handler
     *
     * @return ResponseInterface
     */
    public function process(RequestInterface $request, Handler $handler): ResponseInterface;
}
