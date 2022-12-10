<?php

namespace Aedart\ETags\Helpers;

use Aedart\Contracts\ETags\Collection;
use Aedart\Contracts\ETags\ETag;
use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;

/**
 * Request Preconditions Evaluator
 *
 * Responsible for evaluating request preconditions, according to RFC9110
 * @see https://httpwg.org/specs/rfc9110.html#evaluation
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags
 */
class PreconditionsEvaluator
{
    /**
     * Callback that can determine if state change has already succeeded
     *
     * @var callable|null
     */
    protected $stateChangeSucceededCallback = null;

    /**
     * Callback to invoke when aborting due to state change already has
     * succeeded
     *
     * @var callable|null
     */
    protected $abortStateChangeSucceededCallback = null;

    /**
     * Callback to invoke when aborting request due to precondition failure
     *
     * @var callable|null
     */
    protected $abortPreconditionFailedCallback = null;

    /**
     * Callback to be invoked when aborting request due to "resource not modified"
     *
     * @var callable|null
     */
    protected $abortNotModifiedCallback = null;

    /**
     * Creates a new "request preconditions evaluator" instance
     *
     * @param  Request  $request The received request
     */
    public function __construct(
        protected Request $request
    ) {}

    /**
     * Returns a new "request preconditions evaluator" instance
     *
     * @param  Request  $request The received request
     *
     * @return static
     */
    public static function make(Request $request): static
    {
        return new static($request);
    }

    // TODO
    public function evaluate(ETag|null $etag = null, DateTimeInterface|null $lastModified = null): void
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
        $headers = $this->getHeaders();

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
     * Set callback that determines if state-changing request has already succeeded
     *
     * If a successful state change can be determined, then request is aborted vis
     * a 2xx success status. Otherwise, the request is aborted with a precondition
     * failed status.
     *
     * Example: If a DELETE resource request is made and the resource is already deleted,
     * then the callback can return true.
     *
     * The callback is only invoked as a result of a failed precondition of
     * "If-Match" or "If-Unmodified-Since" http conditional requests.
     *
     * @param  callable|null  $callback  [optional] Request instance is given as callback argument.
     *                                   Callback MUST return boolean value!
     *
     * @return self
     */
    public function determineStateChangeSuccess(callable|null $callback = null): static
    {
        $this->stateChangeSucceededCallback = $callback;

        return $this;
    }

    /**
     * Set callback to be invoked when aborting request due to state change has already
     * succeeded.
     *
     * The callback MUST abort request with a "2xx" successful status. Commonly, this
     * can be achieved by throwing an {@see HttpException}.
     *
     * @param  callable|null  $callback  [optional] Request instance is given as callback argument.
     *                                   Callback MUST abort request, e.g. by throwing an exception.
     *
     * @return self
     */
    public function onAbortStateChangeSucceeded(callable|null $callback = null): static
    {
        $this->abortStateChangeSucceededCallback = $callback;

        return $this;
    }

    /**
     * Set callback to be invoked when aborting request due to precondition failure
     *
     * The callback MUST abort request with a "412 Precondition Failed" client error.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/412
     *
     * @param  callable|null  $callback  [optional] Request instance is given as callback argument.
     *                                   Callback MUST abort request, e.g. by throwing an exception.
     *
     * @return self
     */
    public function onAbortPreconditionFailed(callable|null $callback = null): static
    {
        $this->abortPreconditionFailedCallback = $callback;

        return $this;
    }

    /**
     * Set callback to be invoked when aborting request due to resource not modified
     *
     * The callback MUST abort request with a "304 Not Modified" response.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/304
     *
     * @param  callable|null  $callback  [optional] Request instance is given as callback argument.
     *                                   Callback MUST abort request, e.g. by throwing an exception.
     *
     * @return self
     */
    public function onAbortNotModified(callable|null $callback = null): static
    {
        $this->abortNotModifiedCallback = $callback;

        return $this;
    }

    /**
     * TODO: ... This too must somehow be customizable via callbacks... or similar.
     *
     * Determine if "Range" request is supported by the resource
     *
     * @return bool
     */
    public function isRangeRequestSupported(): bool
    {
        return false;
    }

    /**
     * Get the received request instance
     *
     * @return Request
     */
    public function request(): Request
    {
        return $this->request;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Abort request with a "2xx" successful status, due to state change already
     * succeeded.
     *
     * @see onAbortStateChangeSucceeded
     * @see checkResourceStateChange
     *
     * @return never
     *
     * @throws HttpException
     */
    protected function abortStateChangeAlreadySucceeded(): void
    {
        $callback = $this->abortStateChangeSucceededCallback ?? function() {
            throw new HttpException(200);
        };

        $callback($this->request());
    }

    /**
     * Abort request with a "412 Precondition Failed" client error
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/412
     * @see onAbortPreconditionFailed
     *
     * @return never
     *
     * @throws HttpException
     */
    protected function abortPreconditionFailed()
    {
        $callback = $this->abortPreconditionFailedCallback ?? function() {
            throw new PreconditionFailedHttpException();
        };

        $callback($this->request());
    }

    /**
     * Abort request with a "304 Not Modified"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/304
     * @see onAbortNotModified
     *
     * @return never
     *
     * @throws HttpException
     */
    protected function abortNotModified()
    {
        $callback = $this->abortNotModifiedCallback ?? function() {
            throw new HttpException(304);
        };

        $callback($this->request());
    }

    /**
     * Get the request method
     *
     * @return string
     */
    protected function getMethod(): string
    {
        return $this->request()->getMethod();
    }

    /**
     * Determine if request method is safe or not
     *
     * @see https://developer.mozilla.org/en-US/docs/Glossary/Safe/HTTP
     * @see https://developer.mozilla.org/en-US/docs/Glossary/Idempotent
     *
     * @return bool
     */
    protected function isSafeMethod(): bool
    {
        return $this->request()->isMethodSafe();
    }

    /**
     * Get the Http Headers
     *
     * @return HeaderBag
     */
    protected function getHeaders(): HeaderBag
    {
        return $this->request()->headers;
    }

    /**
     * Get collection of etags from the If-Match header
     *
     * @return Collection
     */
    protected function getIfMatchEtags(): Collection
    {
        // @see \Aedart\ETags\Mixins\RequestETagsMixin::ifMatchEtags
        return $this->request()->ifMatchEtags();
    }

    /**
     * Get collection of etags from the If-None-Match header
     *
     * @return Collection
     */
    protected function getIfNoneMatchEtags(): Collection
    {
        // @see \Aedart\ETags\Mixins\RequestETagsMixin::ifNoneMatchEtags
        return $this->request()->ifNoneMatchEtags();
    }

    /**
     * Get `If-Unmodified-Since` Http Date, when available
     *
     * @return DateTimeInterface|null
     */
    protected function getIfUnmodifiedSinceDate(): DateTimeInterface|null
    {
        // @see \Aedart\ETags\Mixins\RequestETagsMixin::ifUnmodifiedSinceDate
        return $this->request()->ifUnmodifiedSinceDate();
    }

    /**
     * Get `If-Modified-Since` Http Date, when available
     *
     * @return DateTimeInterface|null
     */
    protected function getIfModifiedSinceDate(): DateTimeInterface|null
    {
        // @see \Aedart\ETags\Mixins\RequestETagsMixin::ifModifiedSinceDate
        return $this->request()->ifModifiedSinceDate();
    }

    /**
     * Get Etag or Datetime from the `If-Range` header, if any is available
     *
     * @return ETag|DateTimeInterface|null
     */
    protected function getIfRangeEtagOrDate(): ETag|DateTimeInterface|null
    {
        // @see \Aedart\ETags\Mixins\RequestETagsMixin::ifRangeEtagOrDate
        return $this->request()->ifRangeEtagOrDate();
    }

    /**
     * Determine if state-changing request has already succeeded
     *
     * This method SHOULD only be invoked for none-safe methods,
     * e.g. POST, PUT, DELETE... etc.
     *
     * @see checkResourceStateChange
     * @see determineStateChangeSuccess
     *
     * @return bool
     */
    public function hasStateChangeAlreadySucceeded(): bool
    {
        $callback = $this->stateChangeSucceededCallback ?? fn() => false;

        return $callback($this->request());
    }

    /**
     * Determines if a state change has already succeeded and reacts accordingly.
     *
     * @see abortStateChangeAlreadySucceeded()
     * @see abortPreconditionFailed()
     *
     * @return never
     *
     * @throws HttpException
     */
    protected function checkResourceStateChange()
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
        $ifMatchCollection = $this->getIfMatchEtags();

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
        $ifUnmodifiedSince = $this->getIfUnmodifiedSinceDate();
        if (!isset($ifUnmodifiedSince)) {
            return false;
        }

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
        $ifNoneMatchCollection = $this->getIfNoneMatchEtags();

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
        $ifModifiedSince = $this->getIfModifiedSinceDate();
        if (!isset($ifModifiedSince)) {
            return true;
        }

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
        $value = $this->getIfRangeEtagOrDate();

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