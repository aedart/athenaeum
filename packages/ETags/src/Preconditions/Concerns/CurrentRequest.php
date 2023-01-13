<?php

namespace Aedart\ETags\Preconditions\Concerns;

use Aedart\Contracts\ETags\Collection;
use Aedart\Contracts\ETags\ETag;
use DateTimeInterface;

/**
 * Concerns Current Precondition Request
 *
 * @see \Aedart\Contracts\ETags\Preconditions\HasRequest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions\Concerns
 */
trait CurrentRequest
{
    /**
     * The current request
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Set the request
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return self
     */
    public function setRequest($request): static
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get the request
     *
     * @return \Illuminate\Http\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Alias for {@see getRequest()}
     *
     * @return \Illuminate\Http\Request
     */
    public function request()
    {
        return $this->getRequest();
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
     * @return \Symfony\Component\HttpFoundation\HeaderBag
     */
    protected function getHeaders()
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
}