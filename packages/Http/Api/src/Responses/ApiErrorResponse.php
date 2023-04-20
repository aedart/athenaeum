<?php

namespace Aedart\Http\Api\Responses;

use Aedart\Support\Facades\IoCFacade;
use Aedart\Utils\Arr;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Teapot\StatusCode\All as HttpStatus;
use Throwable;

/**
 * Api Error Response
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Responses
 */
class ApiErrorResponse extends JsonResponse
{
    /**
     * Returns a new Api error response
     *
     * @param  string  $message  [optional]
     * @param  int  $status  [optional]
     * @param  array  $source  [optional]
     * @param  Request|null  $request  [optional]
     *
     * @return static
     */
    public static function make(
        string $message = 'Internal Server Error',
        int $status = HttpStatus::INTERNAL_SERVER_ERROR,
        array $source = [],
        Request|null $request = null
    ): static {
        $payload = static::formatPayload($message, $status, $source, $request);

        return (new static($payload, $status))
            ->setEncodingOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Returns a new APi error response, for given exception
     *
     * @param  Throwable  $e
     * @param  int|null  $status  [optional]
     * @param  Request|null  $request  [optional]
     *
     * @return static
     */
    public static function makeFor(Throwable $e, int|null $status = null, Request|null $request = null): static
    {
        $isHttpException = static::isHttpException($e);

        // Resolve Http Status Code
        if (!isset($status) && $isHttpException) {
            $status = $e->getStatusCode();
        } elseif (!isset($status)) {
            $status = HttpStatus::INTERNAL_SERVER_ERROR;
        }

        // Resolve status text, based on status code
        $message = Response::$statusTexts[$status] ?? $e->getMessage();

        // Create new Api error response
        $response = static::make(
            $message,
            $status,
            static::formatSourceForException($e, $request)
        )->withException($e);

        // Add evt. http headers, if the exception offers any
        if ($isHttpException || method_exists($e, 'getHeaders')) {
            return $response->withHeaders($e->getHeaders());
        }

        return $response;
    }

    /**
     * Format error response payload
     *
     * @param  string  $message  [optional]
     * @param  int  $status  [optional]
     * @param  array  $source  [optional]
     * @param  Request|null  $request  [optional]
     *
     * @return array
     */
    public static function formatPayload(
        string $message = 'Internal Server Error',
        int $status = HttpStatus::INTERNAL_SERVER_ERROR,
        array $source = [],
        Request|null $request = null
    ): array {
        return [
            'status' => $status,
            'message' => $message,
            'source' => $source
        ];
    }

    /**
     * Format "source" for given exception
     *
     * @param  Throwable  $e
     *
     * @return array
     */

    /**
     * Format "source" for given exception
     *
     * @param  Throwable  $e
     * @param  Request|null  $request  [optional]
     *
     * @return array
     */
    public static function formatSourceForException(Throwable $e, Request|null $request = null): array
    {
        // Skip formatting exception details, when application is NOT running
        // in debug mode. Otherwise, we risk exposing sensitive information!
        if (!static::isApplicationRunningDebugMode()) {
            return [];
        }

        // Format exception...
        return [
            'message' => $e->getMessage(),
            'exception' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),

            'trace' => collect($e->getTrace())->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all(),
        ];
    }

    /**
     * Determine if exception is of type "http" exception
     *
     * @param Throwable $e
     *
     * @return bool
     */
    protected static function isHttpException(Throwable $e): bool
    {
        return $e instanceof HttpExceptionInterface;
    }

    /**
     * Determine if application is running in debug mode
     *
     * @return bool
     */
    protected static function isApplicationRunningDebugMode(): bool
    {
        /** @var \Illuminate\Contracts\Config\Repository $config */
        $config = IoCFacade::tryMake('config');

        if (!isset($config)) {
            return false;
        }

        return $config->get('app.debug', false);
    }
}
