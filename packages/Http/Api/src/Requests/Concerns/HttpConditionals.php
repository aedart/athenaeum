<?php

namespace Aedart\Http\Api\Requests\Concerns;

/**
 * Concerns Http Conditionals
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests\Concerns
 */
trait HttpConditionals
{
    /**
     * Determine if Http Conditional Request Headers must be evaluated
     *
     * @see evaluateRequestPreconditions()
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Conditional_requests#conditional_headers
     *
     * @return bool
     */
    abstract public function mustEvaluateConditionalHeaders(): bool;

    // TODO:
    public function evaluateRequestPreconditions()
    {
        // [...] a server MUST ignore the conditional request header fields [...] when received with a
        // request method that does not involve the selection or modification of a selected representation,
        // such as CONNECT, OPTIONS, or TRACE [...]
        // @see https://httpwg.org/specs/rfc9110.html#when.to.evaluate
        if (in_array($this->getMethod(), ['CONNECT', 'OPTIONS', 'TRACE'])) {
            return;
        }

        // "[...] When more than one conditional request header field is present in a request, the order
        // in which the fields are evaluated becomes important [...]"
        // @see https://httpwg.org/specs/rfc9110.html#precedence
        $headers = $this->headers;

        // 1. When recipient is the origin server and If-Match is present, [...]:
        if ($headers->has('If-Match')) {
            // TODO: Evaluate If-Match...

            // TODO: To skip...
            // goto three;
        }

        // 2. When recipient is the origin server, If-Match is not present, and If-Unmodified-Since is present, [...]:
        if (!$headers->has('If-Match') && $headers->has('If-Unmodified-Since')) {
            // TODO: Evaluate If-Unmodified-Since...
        }

        // 3. When If-None-Match is present, [...]:
        three:
        if ($headers->has('If-None-Match')) {
            // TODO: Evaluate If-None-Match...
        }

        // 4. When the method is GET or HEAD, If-None-Match is not present, and If-Modified-Since is present, [...]:
        if (in_array($this->getMethod(), ['GET', 'HEAD']) && !$headers->has('If-None-Match') && $headers->has('If-Modified-Since')) {
            // TODO: Evaluate If-Modified-Since...
        }

        // 5. When the method is GET and both Range and If-Range are present, [...]:
        five:
        if ($this->getMethod() === 'GET' && $headers->has('Range') && $headers->has('If-Range')) {
            // TODO: Evaluate If-Range... ... if at all possible?!
        }

        // 6. Otherwise:
        //      [...] perform the requested method and respond according to its success or failure [...]
    }

    /**
     * Alias for {@see isMethodSafe()}
     *
     * @see https://developer.mozilla.org/en-US/docs/Glossary/Safe/HTTP
     * @see https://developer.mozilla.org/en-US/docs/Glossary/Idempotent
     *
     * @return bool
     */
    public function isSafeMethod(): bool
    {
        return $this->isMethodSafe();
    }
}