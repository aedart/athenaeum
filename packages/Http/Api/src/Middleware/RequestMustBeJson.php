<?php

namespace Aedart\Http\Api\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Request Must Be Json Middleware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Middleware
 */
class RequestMustBeJson
{
    /**
     * Target HTTP methods (methods that can contain data in their body)
     *
     * @var string[]
     */
    protected static array $targetMethods = [
        SymfonyRequest::METHOD_POST,
        SymfonyRequest::METHOD_PUT,
        SymfonyRequest::METHOD_PATCH,
        SymfonyRequest::METHOD_DELETE,
    ];

    /**
     * Ensures request has appropriate JSON content-type / accept headers
     *
     * @param  Request  $request
     * @param  Closure  $next
     *
     * @return mixed
     *
     * @throws BadRequestHttpException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Ensure requests that can contain data have appropriate JSON Content-Type header
        if (in_array(strtoupper($request->method()), static::$targetMethods) && !$request->isJson()) {
            throw new BadRequestHttpException('Invalid content-type header. Request can only process JSON content type, e.g. application/json');
        }

        // Ensure requests intended to retrieve data have appropriate JSON Accept header
        if (!$request->wantsJson()) {
            throw new BadRequestHttpException('Invalid accept header. Only JSON response can be delivered, e.g. application/json');
        }

        return $next($request);
    }
}
