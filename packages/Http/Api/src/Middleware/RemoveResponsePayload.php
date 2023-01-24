<?php

namespace Aedart\Http\Api\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Teapot\StatusCode\All as Status;

/**
 * Remove Response Payload Middleware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Middleware
 */
class RemoveResponsePayload
{
    /**
     * Converts response to "204 No Content" when a "no payload" query parameter
     * is requested.
     *
     * Note: If the response is not successful, then it will not be converted.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $key [optional] Name of query parameter
     *
     * @return JsonResponse|Response
     */
    public function handle(Request $request, Closure $next, string $key = 'no_payload')
    {
        /** @var Response|JsonResponse $response */
        $response = $next($request);

        if ($response->isSuccessful()
            && $request->has($key)
            && in_array($request->query($key, false), ['1', 'true', 1, true, 'on', 'yes'])
        ) {
            return $response
                ->setStatusCode(Status::NO_CONTENT)
                ->setContent(null);
        }

        return $response;
    }
}
