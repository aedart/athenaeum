<?php

namespace Aedart\ETags\Mixins;

use Aedart\Contracts\ETags\Collection;
use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\ETags\Exceptions\ETagException;
use Aedart\ETags\Facades\Generator;
use Closure;
use DateTimeInterface;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

/**
 * Request Etags Mixin
 *
 * Mixin is intended for Laravel's {@see \Illuminate\Http\Request}
 *
 * @mixin \Illuminate\Http\Request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Mixins
 */
class RequestETagsMixin
{
    /**
     * Get a collection of etags from given header
     *
     * @return Closure
     */
    public function etagsFrom(): Closure
    {
        return function(string $header): Collection
        {
            try {
                return Generator::parse($this->header($header, ''));
            } catch (ETagException $e) {
                throw new BadRequestHttpException(sprintf('Invalid etag value(s) in %s header', $header), $e);
            }
        };
    }

    /**
     * Get collection of etags from the If-Match header
     *
     * @see https://httpwg.org/specs/rfc9110.html#field.if-match
     *
     * @return Closure
     */
    public function ifMatchEtags(): Closure
    {
        return function(): Collection
        {
            return $this->etagsFrom('If-Match');
        };
    }

    /**
     * Get collection of etags from the If-None-Match header
     *
     * @see https://httpwg.org/specs/rfc9110.html#field.if-none-match
     *
     * @return Closure
     */
    public function ifNoneMatchEtags(): Closure
    {
        return function(): Collection
        {
            return $this->etagsFrom('If-None-Match');
        };
    }

    /**
     * Obtain Etag or Datetime from the If-Range header, if any is available
     *
     * NOTE: This method will only attempt to parse header value into an ETag
     * or Datetime, if If-Range and Range headers have values, as described by
     * RFC-9110.
     *
     * @see https://httpwg.org/specs/rfc9110.html#field.if-range
     *
     * @return Closure
     */
    public function ifRangeEtagOrDate(): Closure
    {
        return function (): ETag|DateTimeInterface|null
        {
            if (!$this->hasIfRangeHeaders()) {
                return null;
            }

            // RFC-9110: "[...] A valid entity-tag can be distinguished from a valid
            // HTTP-date by examining the first three characters for a DQUOTE. [...]"
            // @see https://httpwg.org/specs/rfc9110.html#field.if-range

            $ifRangeValue = $this->header('If-Range');
            if (str_contains(substr($ifRangeValue, 0, 3), '"')) {
                return $this->etagsFrom('If-Range')[0];
            }

            // Otherwise we assume that an HTTP-date has been given and must
            // attempt to convert it into a datetime...
            try {
                return Carbon::make($ifRangeValue);
            } catch (Throwable $e) {
                throw new BadRequestHttpException(sprintf('Invalid HTTP-Date value in If-Range header: %s', $ifRangeValue), $e);
            }
        };
    }

    /**
     * Determine if request has If-Range and Rage header values set
     *
     * @see https://httpwg.org/specs/rfc9110.html#field.if-range
     *
     * @return Closure
     */
    public function hasIfRangeHeaders(): Closure
    {
        return function(): bool
        {
            // From RFC-9110
            // [...] A server MUST ignore an If-Range header field received in a request
            // that does not contain a Range header field [...]
            // @see https://httpwg.org/specs/rfc9110.html#field.if-range

            return $this->hasHeader('If-Range') && $this->hasHeader('Range');
        };
    }
}