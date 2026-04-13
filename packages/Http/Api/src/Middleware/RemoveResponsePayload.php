<?php

namespace Aedart\Http\Api\Middleware;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Streams\FileStream;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
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
     * Values that are deemed truthy
     *
     * @var array
     */
    protected static array $values = [
        '1',
        'true',
        1,
        true,
        'on',
        'yes'
    ];

    /**
     * Converts response to "204 No Content" when a "no payload" query parameter
     * is requested.
     *
     * Note: If the response is not successful, then it will not be converted.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string  $key  [optional] Query parameter that must trigger this middleware.
     *
     * @return mixed
     *
     * @throws StreamException
     */
    public function handle(Request $request, Closure $next, string $key = 'no_payload'): mixed
    {
        /** @var Response|SymfonyResponse|ResponseInterface|null $response */
        $response = $next($request);

        // When no response available,...
        if (!isset($response)) {
            return $response;
        }

        // Early exit if "no payload" wasn't requested.
        $noPayloadRequested = $request->has($key) && in_array($request->query($key, false), static::$values);
        if (!$noPayloadRequested) {
            return $response;
        }

        if ($response instanceof SymfonyResponse && $response->isSuccessful()) {
            return $response
                ->setStatusCode(Status::NO_CONTENT)
                ->setContent(null);
        }

        if ($response instanceof ResponseInterface && $response->getStatusCode() >= Status::OK && $response->getStatusCode() < Status::MULTIPLE_OPTIONS) {
            $nullStream = FileStream::openMemory()
                ->append('')
                ->positionToStart();

            return $response
                ->withStatus(Status::NO_CONTENT)
                ->withBody($nullStream);
        }

        // Fall through, if not request was not successful or of unknown kind.
        return $response;
    }
}
