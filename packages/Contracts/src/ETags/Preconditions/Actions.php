<?php

namespace Aedart\Contracts\ETags\Preconditions;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Precondition Actions
 *
 * Contains various "abort" or "state change" actions that
 * a request precondition can invoke when it passes or fails.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\ETags\Preconditions
 */
interface Actions
{
    /**
     * Abort request with a "2xx" successful status, due to state change already
     * succeeded.
     *
     * [...] if the request is a state-changing operation that appears to have already been
     * applied to the selected representation, the origin server MAY respond with a
     * 2xx (Successful) status code [...]
     *
     * @see https://httpwg.org/specs/rfc9110.html#conditional.requests
     *
     * @param  ResourceContext  $resource
     *
     * @return never
     *
     * @throws HttpExceptionInterface
     */
    public function abortStateChangeAlreadySucceeded(ResourceContext $resource);

    /**
     * Abort request with a "412 Precondition Failed" client error
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/412
     *
     * @param  ResourceContext  $resource
     *
     * @return never
     *
     * @throws HttpExceptionInterface
     */
    public function abortPreconditionFailed(ResourceContext $resource);

    /**
     * Abort request with a "304 Not Modified"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/304
     *
     * @param  ResourceContext  $resource
     *
     * @return never
     *
     * @throws HttpExceptionInterface
     */
    public function abortNotModified(ResourceContext $resource);

    /**
     * Process "Range" and response "206 Partial Content"
     *
     * Method can choose to change or set state of given resource context,
     * such that the application will react upon it and cause a "206 Partial Content"
     * response. Or, the method can choose to abort the current request and
     * respond accordingly.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/206
     * @see https://httpwg.org/specs/rfc9110.html#field.if-range
     *
     * @param  ResourceContext  $resource
     *
     * @return mixed
     *
     * @throws HttpExceptionInterface
     */
    public function processRangeHeader(ResourceContext $resource): mixed;

    /**
     * Ignores "Range" header and proceeds regular request processing
     *
     * Method can choose to change or set state of given resource context,
     * such that the application will ignore "Range" header field. Or, the
     * method can choose to abort the current request and respond accordingly.
     *
     * @see https://httpwg.org/specs/rfc9110.html#field.if-range
     *
     * @param  ResourceContext  $resource
     *
     * @return mixed
     *
     * @throws HttpExceptionInterface
     */
    public function ignoreRangeHeader(ResourceContext $resource): mixed;
}