<?php

namespace Aedart\Testing\Helpers\Http;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Utils\Json;
use JsonException;

/**
 * Response
 *
 * Http Response test utilities
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\Helpers\Http
 */
class Response
{
    /**
     * Decodes the json payload from given response
     *
     * @param \Illuminate\Testing\TestResponse|\Illuminate\Http\Response $jsonResponse
     * @param bool $debug [optional] Http headers and decoded body is logged to console when true
     *
     * @return array Decoded contents
     *
     * @throws JsonException
     */
    public static function decode($jsonResponse, bool $debug = true): array
    {
        $content = [];
        $body = $jsonResponse->getContent();

        if (!empty($body)) {
            $content = Json::decode($body, true);
        }

        if ($debug) {
            ConsoleDebugger::output([
                'status' => $jsonResponse->getStatusCode() . ' ' . $jsonResponse->statusText(),
                'headers' => $jsonResponse->headers->all(),
                'body' => $content
            ]);
        }

        return $content;
    }

    /**
     * Returns stream content of response
     *
     * @param \Illuminate\Testing\TestResponse|\Symfony\Component\HttpFoundation\StreamedResponse $response
     * @param bool $debug [optional] Http headers and stream content is logged to console when true.
     *
     * @return string
     */
    public static function streamResponse($response, bool $debug = true): string
    {
        $content = $response->streamedContent();

        if ($debug) {
            ConsoleDebugger::output([
                'status' => $response->getStatusCode() /*. ' ' . $response->statusText(),*/,
                'headers' => $response->headers->all(),
                'body' => $content
            ]);
        }

        return $content;
    }

    /**
     * Creates a new multipart response instance from given response
     *
     * @param \Illuminate\Testing\TestResponse|\Symfony\Component\HttpFoundation\StreamedResponse $response
     * @param bool $debug [optional] Http headers and stream content is logged to console when true.
     *
     * @return MultipartResponse
     */
    public static function multipartResponse($response, bool $debug = true)
    {
        $multipartResponse = MultipartResponse::from($response);

        if ($debug) {
            ConsoleDebugger::output($multipartResponse);
        }

        return $multipartResponse;
    }

    /**
     * Returns Http headers from given response
     *
     * @param \Illuminate\Testing\TestResponse|\Illuminate\Http\Response $response
     * @param bool $debug [optional] Http headers are logged to console when true
     *
     * @return \Symfony\Component\HttpFoundation\ResponseHeaderBag
     */
    public static function headers($response, bool $debug = true)
    {
        $headers = $response->headers;

        if ($debug) {
            ConsoleDebugger::output($headers->all());
        }

        return $headers;
    }
}
