<?php

namespace Aedart\Http\Clients\Traits;

use Aedart\Contracts\Http\Clients\Requests\Builder;

/**
 * HttpRequestBuilderTrait
 *
 * @see \Aedart\Contracts\Http\Clients\Requests\Builders\HttpRequestBuilderAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Traits
 */
trait HttpRequestBuilderTrait
{
    /**
     * Http Request Builder instance
     *
     * @var Builder|null
     */
    protected Builder|null $httpRequestBuilder = null;

    /**
     * Set http request builder
     *
     * @param  Builder|null  $builder  Http Request Builder instance
     *
     * @return self
     */
    public function setHttpRequestBuilder(Builder|null $builder): static
    {
        $this->httpRequestBuilder = $builder;

        return $this;
    }

    /**
     * Get http request builder
     *
     * If no http request builder has been set, this method will
     * set and return a default http request builder, if any such
     * value is available
     *
     * @return Builder|null http request builder or null if none http request builder has been set
     */
    public function getHttpRequestBuilder(): Builder|null
    {
        if (!$this->hasHttpRequestBuilder()) {
            $this->setHttpRequestBuilder($this->getDefaultHttpRequestBuilder());
        }
        return $this->httpRequestBuilder;
    }

    /**
     * Check if http request builder has been set
     *
     * @return bool True if http request builder has been set, false if not
     */
    public function hasHttpRequestBuilder(): bool
    {
        return isset($this->httpRequestBuilder);
    }

    /**
     * Get a default http request builder value, if any is available
     *
     * @return Builder|null A default http request builder value or Null if no default value is available
     */
    public function getDefaultHttpRequestBuilder(): Builder|null
    {
        return null;
    }
}
