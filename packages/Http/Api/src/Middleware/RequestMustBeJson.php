<?php

namespace Aedart\Http\Api\Middleware;

use Closure;
use Illuminate\Http\Request;
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
     * Ensures request has appropriate JSON content-type / accept headers
     *
     * @param  Request  $request
     * @param  Closure  $next
     *
     * @return mixed
     *
     * @throws BadRequestHttpException
     */
    public function handle(Request $request, Closure $next)
    {
        // Ensure requests that can contain data have appropriate JSON Content-Type header
        $method = strtolower($request->method());
        if (in_array($method, [ 'post', 'put', 'patch', 'delete' ]) && !$request->isJson()) {
            throw new BadRequestHttpException('Invalid content-type header. Request can only process JSON content type, e.g. application/json');
        }

        // Ensure requests intended to retrieve data have appropriate JSON Accept header
        if (!$request->wantsJson()) {
            throw new BadRequestHttpException('Invalid accept header. Only JSON response can be delivered, e.g. application/json');
        }

        return $next($request);
    }
}
