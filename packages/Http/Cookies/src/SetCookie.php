<?php

namespace Aedart\Http\Cookies;

use Aedart\Contracts\Http\Cookies\SetCookie as SetCookieInterface;
use DateTime;

/**
 * Http Set-Cookie
 *
 * @see \Aedart\Contracts\Http\Cookies\SetCookie
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Cookies
 */
class SetCookie extends Cookie implements SetCookieInterface
{
    /**
     * Maximum lifetime of cookie
     *
     * @var string|null
     */
    protected string|null $expires = null;

    /**
     * Number of seconds until the cookie expires
     *
     * @var int|null
     */
    protected int|null $maxAge = null;

    /**
     * Host(s) where the cookie will be sent to
     *
     * @var string|null
     */
    protected string|null $domain = null;

    /**
     * Cookie path that must exist on the requested url
     *
     * @var string|null
     */
    protected string|null $path = '/';

    /**
     * Whether the cookie should be sent via https
     *
     * @var bool
     */
    protected bool $secure = false;

    /**
     * Http only state; If true, accessing the cookie
     * is forbidden via JavaScript.
     *
     * @var bool
     */
    protected bool $httpOnly = false;

    /**
     * Same-site policy; whether cookie should be available
     * for cross-site requests
     *
     * @see SetCookieInterface::SAME_SITE_STRICT
     * @see SetCookieInterface::SAME_SITE_LAX
     * @see SetCookieInterface::SAME_SITE_NONE
     *
     * @var string|null
     */
    protected string|null $sameSite = null;

    /**
     * @inheritDoc
     */
    public function expires(string|int|null $expiresAt = null): static
    {
        if (isset($expiresAt) && is_int($expiresAt)) {
            $expiresAt = gmdate(DateTime::RFC7231, $expiresAt);
        }

        $this->expires = $expiresAt;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getExpires(): string|null
    {
        return $this->expires;
    }

    /**
     * @inheritDoc
     */
    public function maxAge(int|null $seconds = null): static
    {
        $this->maxAge = $seconds;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getMaxAge(): int|null
    {
        return $this->maxAge;
    }

    /**
     * @inheritDoc
     */
    public function domain(string|null $domain = null): static
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDomain(): string|null
    {
        return $this->domain;
    }

    /**
     * @inheritDoc
     */
    public function path(string|null $path = null): static
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPath(): string|null
    {
        return $this->path;
    }

    /**
     * @inheritDoc
     */
    public function secure(bool $isSecure = false): static
    {
        $this->secure = $isSecure;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSecure(): bool
    {
        return $this->secure;
    }

    /**
     * @inheritDoc
     */
    public function isSecure(): bool
    {
        return $this->getSecure();
    }

    /**
     * @inheritDoc
     */
    public function httpOnly(bool $httpOnly = false): static
    {
        $this->httpOnly = $httpOnly;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getHttpOnly(): bool
    {
        return $this->httpOnly;
    }

    /**
     * @inheritDoc
     */
    public function isHttpOnly(): bool
    {
        return $this->getHttpOnly();
    }

    /**
     * @inheritDoc
     */
    public function sameSite(string|null $policy = null): static
    {
        $this->sameSite = $policy;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSameSite(): string|null
    {
        return $this->sameSite;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'expires' => $this->getExpires(),
            'maxAge' => $this->getMaxAge(),
            'domain' => $this->getDomain(),
            'path' => $this->getPath(),
            'secure' => $this->isSecure(),
            'httpOnly' => $this->isHttpOnly(),
            'sameSite' => $this->getSameSite()
        ]);
    }
}
