<?php

namespace Aedart\Contracts\Http\Clients\Requests;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Handles a request and produces a response
 *
 * Heavily inspired by PSR-15: HTTP Server Request Handlers
 * @see https://www.php-fig.org/psr/psr-15/
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients\Requests
 */
interface Handler
{
    /**
     * Handles given request and produces a response
     *
     * Heavily inspired by PSR-15: HTTP Server Request Handlers
     * @see https://www.php-fig.org/psr/psr-15/
     *
     * @param  RequestInterface  $request
     *
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request): ResponseInterface;
}
