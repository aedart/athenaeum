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
        return function (string $header): Collection {
            try {
                $value = $this->header($header);
                if (empty($value)) {
                    $value = '';
                }

                return Generator::parse($value);
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
        return function (): Collection {
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
        return function (): Collection {
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
        return function (): ETag|DateTimeInterface|null {
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
            return $this->httpDateFrom('If-Range');
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
        return function (): bool {
            // From RFC-9110
            // [...] A server MUST ignore an If-Range header field received in a request
            // that does not contain a Range header field [...]
            // @see https://httpwg.org/specs/rfc9110.html#field.if-range

            return $this->hasHeader('If-Range') && $this->hasHeader('Range');
        };
    }

    /**
     * Obtain HTTP-Date from given header
     *
     * @return Closure
     */
    public function httpDateFrom(): Closure
    {
        return function (string $header): DateTimeInterface|null {
            $value = $this->header($header);
            if (empty($value)) {
                return null;
            }

            try {
                return Carbon::createFromTimeString($value, 'GMT');
            } catch (Throwable $e) {
                throw new BadRequestHttpException(sprintf('Invalid HTTP-Date value in %s header', $header), $e);
            }
        };
    }

    /**
     * Obtain `If-Modified-Since` Http Date, when available
     *
     * The Http Date is available when `If-Modified-Since` header is given,
     * the request method is either GET or HEAD, and there is no `If-None-Match` header value
     * specified.
     *
     * @see https://httpwg.org/specs/rfc9110.html#field.if-modified-since
     *
     * @return Closure
     */
    public function ifModifiedSinceDate(): Closure
    {
        return function (): DateTimeInterface|null {
            // From RFC-9110:
            // "[...] A recipient MUST ignore If-Modified-Since if the request contains an If-None-Match header field
            // [...] A recipient MUST ignore the If-Modified-Since header field if the received field value
            // is not a valid HTTP-date, the field value has more than one member, or if the
            // request method is neither GET nor HEAD. [...]"
            // @see https://httpwg.org/specs/rfc9110.html#field.if-modified-since

            if (!in_array(strtoupper($this->method()), [ 'GET', 'HEAD' ]) || $this->hasHeader('If-None-Match')) {
                return null;
            }

            return $this->httpDateFrom('If-Modified-Since');
        };
    }

    /**
     * Obtain `If-Unmodified-Since` Http Date, when available
     *
     * The Http Date is available when `If-Unmodified-Since` header is given,
     * and there is no `If-Match` header value specified.
     *
     * @return Closure
     */
    public function ifUnmodifiedSinceDate(): Closure
    {
        return function (): DateTimeInterface|null {
            // From RFC-9110:
            // "[...] A recipient MUST ignore If-Unmodified-Since if the request contains an If-Match header field
            // [...] A recipient MUST ignore the If-Unmodified-Since header field if the received field value is
            // not a valid HTTP-date (including when the field value appears to be a list of dates) [...]"
            // @see https://httpwg.org/specs/rfc9110.html#field.if-unmodified-since

            if ($this->hasHeader('If-Match')) {
                return null;
            }

            return $this->httpDateFrom('If-Unmodified-Since');
        };
    }
}
