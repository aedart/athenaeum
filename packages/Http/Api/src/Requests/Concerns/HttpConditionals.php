<?php

namespace Aedart\Http\Api\Requests\Concerns;

use Aedart\Contracts\ETags\Collection;
use Aedart\Contracts\ETags\ETag;
use DateTimeInterface;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;

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
    abstract public function mustEvaluateRequestPreconditions(): bool;

    // TODO:
    public function evaluateRequestPreconditions(ETag|null $etag = null, DateTimeInterface|null $lastModified = null): void
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
            if ($this->ifMatchConditionPasses($etag)) {
                // [...] if true, continue to step 3
                goto three;
            }

            $this->checkResourceStateChange();
        }

        // 2. When recipient is the origin server, If-Match is not present, and If-Unmodified-Since is present, [...]:
        if ($headers->has('If-Unmodified-Since') && !$headers->has('If-Match') && isset($lastModified)) {
            // [...] A recipient MUST ignore the If-Unmodified-Since header field if the resource does
            // not have a modification date available. [...]
            if ($this->ifUnmodifiedSinceConditionPasses($lastModified)) {
                // [...] if true, continue to step 3
                goto three;
            }

            $this->checkResourceStateChange();
        }

        // 3. When If-None-Match is present, [...]:
        three:
        if ($headers->has('If-None-Match')) {
            if ($this->ifNoneMatchConditionPasses($etag)) {
                // [...] if true, continue to step 5
                goto five;
            }

            // [...] if false for GET/HEAD, respond 304 (Not Modified)
            if (in_array($this->getMethod(), ['GET', 'HEAD'])) {
                $this->abortNotModified();
            }

            // [...] if false for other methods, respond 412 (Precondition Failed)
            $this->abortPreconditionFailed();
        }

        // 4. When the method is GET or HEAD, If-None-Match is not present, and If-Modified-Since is present, [...]:
        if ($headers->has('If-Modified-Since') && !$headers->has('If-None-Match') && in_array($this->getMethod(), ['GET', 'HEAD']) && isset($lastModified)) {
            // [...] A recipient MUST ignore the If-Modified-Since header field if the resource does
            // not have a modification date available. [...]
            if ($this->ifModifiedSinceConditionPasses($lastModified)) {
                // [...] if true, continue to step 5
                goto five;
            }

            // [...] if false, respond 304 (Not Modified)
            $this->abortNotModified();
        }

        // 5. When the method is GET and both Range and If-Range are present, [...]:
        five:
        if ($headers->has('If-Range') && $headers->has('Range') && $this->getMethod() === 'GET' && $this->isRangeRequestSupported()) {
            // [...] An origin server MUST ignore an If-Range header field received in a request for
            // a target resource that does not support Range requests. [...]
            // TODO: is "range" applicable callback ... or something... ???
            if ($this->ifRangeConditionPasses($etag, $lastModified)) {
                // [...] if true and the Range is applicable to the selected representation,
                // respond 206 (Partial Content) [...]
                // TODO: Uhm... callback?.. or?
            }

            // [...] otherwise, ignore the Range header field and respond 200 (OK) [...]
                // -> In this case we let the request proceed, so it can respond accordingly.
        }

        // 6. Otherwise:
        //      [...] perform the requested method and respond according to its success or failure [...]
    }

    /**
     * Determine if state-changing request has already succeeded
     *
     * This method SHOULD only be invoked for none-safe methods,
     * e.g. POST, PUT, DELETE... etc.
     *
     * @see checkResourceStateChange
     *
     * @return bool
     */
    public function hasStateChangeAlreadySucceeded(): bool
    {
        // Overwrite this method, if you are able to determine if a state-change
        // has already succeeded.
        // Example: If a DELETE resource request is made and the resource is
        // already deleted, then you can return true.

        return false;
    }

    /**
     * Determines if a state change has already succeeded and reacts accordingly.
     *
     * If a successful state change can be determined, then request is aborted vis
     * a 2xx success status. Otherwise, the request is aborted with a precondition
     * failed status.
     *
     * This method should only be invoked as a result of a failed precondition of
     * "If-Match" or "If-Unmodified-Since" http conditional requests.
     *
     * @see abortStateChangeAlreadySucceeded()
     * @see abortPreconditionFailed()
     *
     * @return never
     *
     * @throws HttpException
     */
    public function checkResourceStateChange()
    {
        // [...] if false, respond 412 (Precondition Failed) unless it can be determined that the
        // state-changing request has already succeeded [...]

        if (!$this->isSafeMethod() && $this->hasStateChangeAlreadySucceeded()) {
            // [...]  if the request is a state-changing operation that appears to have already been
            // applied to the selected representation, the origin server MAY respond with a
            // 2xx (Successful) status code [...]
            $this->abortStateChangeAlreadySucceeded();
        }

        // Otherwise, this is not a state-change request or no state change success could be determined.
        // Thus, we abort the request with a "precondition failed"
        $this->abortPreconditionFailed();
    }

    /**
     * Determine if "Range" request is supported by the resource
     *
     * @return bool
     */
    public function isRangeRequestSupported(): bool
    {
        return false;
    }

    /**
     * Abort request with a "2xx" successful status, due to a
     *
     * @return never
     *
     * @throws HttpException
     */
    public function abortStateChangeAlreadySucceeded()
    {
        abort(200);
    }

    /**
     * Abort request with a "412 Precondition Failed" client error
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/412
     *
     * @return never
     *
     * @throws HttpException
     */
    public function abortPreconditionFailed()
    {
        throw new PreconditionFailedHttpException();
    }

    /**
     * Abort request with a "304 Not Modified"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/304
     *
     * @return never
     *
     * @throws HttpException
     */
    public function abortNotModified()
    {
        abort(304);
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

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Determine whether "If-Match" condition passes or not
     *
     * NOTE: Call this method ONLY when an "If-Match" header is available.
     *
     * @see https://httpwg.org/specs/rfc9110.html#field.if-match
     *
     * @param  ETag|null  $etag  [optional] Current resource's etag, if any
     *
     * @return bool
     */
    protected function ifMatchConditionPasses(ETag|null $etag = null): bool
    {
        // Obtain "If-Match" etags collection.
        // @see \Aedart\ETags\Mixins\RequestETagsMixin::ifMatchEtags
        /** @var Collection $ifMatchCollection */
        $ifMatchCollection = $this->ifMatchEtags();

        // An origin server MUST use the strong comparison [...] for If-Match
        if (isset($etag) && $ifMatchCollection->isNotEmpty() && $ifMatchCollection->contains($etag, true)) {
            return true;
        }

        // This means either that there is no current representation of the resource,
        // or that requested etag(s) do not match the etag of the resource.
        return false;
    }

    /**
     * Determine whether "If-Unmodified-Since" condition passes or not
     *
     * NOTE: Call this method ONLY when an "If-Unmodified-Since" header is available,
     * and the requested resource has a last modification date.
     *
     * @see https://httpwg.org/specs/rfc9110.html#field.if-unmodified-since
     *
     * @param  DateTimeInterface  $lastModified Current resource's last modified date
     *
     * @return bool
     */
    protected function ifUnmodifiedSinceConditionPasses(DateTimeInterface $lastModified): bool
    {
        // Obtain requested "If-Unmodified-Since" date
        // @see \Aedart\ETags\Mixins\RequestETagsMixin::ifUnmodifiedSinceDate
        $ifUnmodifiedSince = $this->ifUnmodifiedSinceDate();

        // [...] If the selected representation's last modification date is earlier than or equal to
        // the date provided in the field value, the condition is TRUE. [...]
        return Carbon::instance($lastModified)->lessThanOrEqualTo($ifUnmodifiedSince);
    }

    /**
     * Determine whether "If-None-Match" condition passes or not
     *
     * NOTE: Call this method ONLY when an "If-None-Match" header is available.
     *
     * @see https://httpwg.org/specs/rfc9110.html#field.if-none-match
     *
     * @param  ETag|null  $etag  [optional] Current resource's etag, if any
     *
     * @return bool
     */
    protected function ifNoneMatchConditionPasses(ETag|null $etag = null): bool
    {
        // Obtain "If-None-Match" etags collection.
        // @see \Aedart\ETags\Mixins\RequestETagsMixin::ifNoneMatchEtags
        /** @var Collection $ifNoneMatchCollection */
        $ifNoneMatchCollection = $this->ifNoneMatchEtags();

        // [...] If the field value is "*", the condition is FALSE if the origin server has a current representation for the target resource.
        // [...] If the field value is a list of entity tags, the condition is FALSE if one of the listed tags matches the entity tag of the selected representation.
        // [...] A recipient MUST use the weak comparison [...] for If-None-Match
        if (isset($etag) && $ifNoneMatchCollection->contains($etag, false)) {
            return false;
        }

        // Otherwise, the condition is true.
        return true;
    }

    /**
     * Determine whether "If-Modified-Since" condition passes or not
     *
     * NOTE: Call this method ONLY when an "If-Modified-Since" header is available,
     * and the requested resource has a last modification date.
     *
     * @see https://httpwg.org/specs/rfc9110.html#field.if-modified-since
     *
     * @param  DateTimeInterface  $lastModified Current resource's last modified date
     *
     * @return bool
     */
    protected function ifModifiedSinceConditionPasses(DateTimeInterface $lastModified): bool
    {
        // Obtain requested "If-Modified-Since" date
        // @see \Aedart\ETags\Mixins\RequestETagsMixin::ifModifiedSinceDate
        $ifModifiedSince = $this->ifModifiedSinceDate();

        // [...] If the selected representation's last modification date is earlier or equal to
        // the date provided in the field value, the condition is FALSE. [...]
        return !Carbon::instance($lastModified)->lessThanOrEqualTo($ifModifiedSince);
    }

    /**
     * Determine whether "If-Range" condition passes or not
     *
     * NOTE: Call this method ONLY when an "If-Range" and "Range" headers are available.
     *
     * @see https://httpwg.org/specs/rfc9110.html#field.if-range
     *
     * @param  ETag|null  $etag  [optional] Resource's etag, if any
     * @param  DateTimeInterface|null  $lastModified  [optional] Resource's last modification date, if any
     *
     * @return bool
     */
    protected function ifRangeConditionPasses(ETag|null $etag = null, DateTimeInterface|null $lastModified = null): bool
    {
        // Obtain requested "If-Range" ETag or Http Date
        // @see \Aedart\ETags\Mixins\RequestETagsMixin::ifRangeEtagOrDate
        $value = $this->ifRangeEtagOrDate();

        // Evaluate etag
        if ($value instanceof ETag) {
            return $this->doesIfRangeEtagMatch($value, $etag);
        }

        // Otherwise, evaluate Http Date...
        if ($value instanceof DateTimeInterface) {
            return $this->doesIfRangeDateMatch($value, $lastModified);
        }

        // If by any change the value was resolved to null, then the condition is false...
        return false;
    }

    /**
     * Determine if the "If-Range" ETag matches that of the resource
     *
     * @param  ETag  $ifRange ETag of If-Range header
     * @param  ETag|null  $etag  [optional] Resource's etag
     *
     * @return bool
     */
    protected function doesIfRangeEtagMatch(ETag $ifRange, ETag|null $etag = null): bool
    {
        // We assume that the condition fails, when the resource has no etag representation...
        if (!isset($etag)) {
            return false;
        }

        // [...] If the entity-tag validator provided exactly matches the ETag field value for the
        // selected representation using the strong comparison [...], the condition is true.
        return $ifRange->matches($etag, true);
    }

    /**
     * Determine if the "If-Range" HttpDate matches the last modification date of resource
     *
     * @param  DateTimeInterface  $ifRange Http Date of If-Range header
     * @param  DateTimeInterface|null  $lastModified  [optional] Resource's last modification date
     *
     * @return bool
     */
    protected function doesIfRangeDateMatch(DateTimeInterface $ifRange, DateTimeInterface|null $lastModified = null): bool
    {
        // We assume the condition fails, when resource has no last modification date...
        if (!isset($lastModified)) {
            return false;
        }

        // [...] If the HTTP-date validator provided is not a strong validator in the sense defined by
        // Section 8.8.2.2, the condition is false. [...]
        // -> Not sure how this can be determined here, or if at all feasible?

        // [...] If the HTTP-date validator provided exactly matches the Last-Modified field value for
        // the selected representation, the condition is true. [...]
        return Carbon::instance($lastModified)->equalTo($ifRange);
    }
}
