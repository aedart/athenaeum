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
     * @inheritdoc
     */
    public function withBaseUrl(string $url): Builder
    {
        $this->baseUrl = $url;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function hasBaseUrl(): bool
    {
        return !empty($this->baseUrl);
    }

    /**
     * @inheritdoc
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
}
