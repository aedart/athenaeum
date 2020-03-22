<?php


namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Requests\Builder;

/**
 * Concerns Base Url
 *
 * @see Builder
 * @see Builder::withBaseUrl
 * @see Builder::hasBaseUrl
 * @see Builder::getBaseUrl
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Concerns
 */
trait BaseUrl
{
    /**
     * Base Url for next request
     *
     * @var string
     */
    protected string $baseUrl = '';

    /**
     * Set the base url for the next request
     *
     * @param string $url
     *
     * @return self
     */
    public function withBaseUrl(string $url): Builder
    {
        $this->baseUrl = $url;

        return $this;
    }

    /**
     * Determine if base url is set for next request
     *
     * @return bool
     */
    public function hasBaseUrl(): bool
    {
        return !empty($this->baseUrl);
    }

    /**
     * Get the base url for the next request
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
}
