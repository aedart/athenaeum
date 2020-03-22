<?php

namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Requests\Builder;

/**
 * Concerns Http Protocol Version
 *
 * @see Builder
 * @see Builder::useProtocolVersion
 * @see Builder::getProtocolVersion
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Concerns
 */
trait HttpProtocolVersion
{
    /**
     * The Http protocol version
     *
     * @var string
     */
    protected string $httpProtocolVersion = '1.1';

    /**
     * Set the HTTP protocol version, for the next request
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Messages
     *
     * @param string $version
     *
     * @return self
     */
    public function useProtocolVersion(string $version): Builder
    {
        $this->httpProtocolVersion = $version;

        return $this;
    }

    /**
     * Get the HTTP protocol version, for the next request
     *
     * @return string
     */
    public function getProtocolVersion(): string
    {
        return $this->httpProtocolVersion;
    }
}
