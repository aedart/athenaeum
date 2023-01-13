<?php

namespace Aedart\ETags\Preconditions\Rfc9110;

use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Preconditions\BasePrecondition;
use Aedart\ETags\Preconditions\Rfc9110\Concerns;
use DateTimeInterface;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * If-Range precondition
 *
 * @see https://httpwg.org/specs/rfc9110.html#field.if-range
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions\Rfc9110
 */
class IfRange extends BasePrecondition
{
    use Concerns\RangeValidation;

    /**
     * @inheritDoc
     */
    public function isApplicable(ResourceContext $resource): bool
    {
        // 5. When the method is GET and both Range and If-Range are present, [...]:
        $headers = $this->getHeaders();

        // [...] A server MUST ignore a Range header field received with a request method that is unrecognized
        // or for which range handling is not defined. For this specification, GET is the only method for
        // which range handling is defined. [...]
        return $resource->supportsRangeRequest()
            && $headers->has('If-Range')
            && $headers->has('Range')
            && $this->getMethod() === 'GET';
    }

    /**
     * {@inheritDoc}
     *
     * @throws HttpExceptionInterface
     */
    public function passes(ResourceContext $resource): bool
    {
        // [...] An origin server MUST ignore an If-Range header field received in a request for
        // a target resource that does not support Range requests. [...]
        return $this->ifRangeConditionPasses($resource->etag(), $resource->lastModifiedDate())
            && $this->isRangeApplicable($resource);
    }

    /**
     * @inheritDoc
     */
    public function whenPasses(ResourceContext $resource): ResourceContext|string
    {
        // [...] if true and the Range is applicable to the selected representation,
        // respond 206 (Partial Content) [...]
        return $this->actions()->processRange($resource, $this->getVerifiedRanges());
    }

    /**
     * @inheritDoc
     */
    public function whenFails(ResourceContext $resource): ResourceContext|string
    {
        // [...] otherwise, ignore the Range header field and respond 200 (OK) [...]
        return $this->actions()->ignoreRange($resource);
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