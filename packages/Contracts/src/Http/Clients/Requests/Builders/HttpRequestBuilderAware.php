<?php

namespace Aedart\Contracts\Http\Clients\Requests\Builders;

use Aedart\Contracts\Http\Clients\Requests\Builder;

/**
 * Http Request Builder Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients\Requests\Builders
 */
interface HttpRequestBuilderAware
{
    /**
     * Set http request builder
     *
     * @param  Builder|null  $builder  Http Request Builder instance
     *
     * @return self
     */
    public function setHttpRequestBuilder(Builder|null $builder): static;

    /**
     * Get http request builder
     *
     * If no http request builder has been set, this method will
     * set and return a default http request builder, if any such
     * value is available
     *
     * @return Builder|null http request builder or null if none http request builder has been set
     */
    public function getHttpRequestBuilder(): Builder|null;

    /**
     * Check if http request builder has been set
     *
     * @return bool True if http request builder has been set, false if not
     */
    public function hasHttpRequestBuilder(): bool;

    /**
     * Get a default http request builder value, if any is available
     *
     * @return Builder|null A default http request builder value or Null if no default value is available
     */
    public function getDefaultHttpRequestBuilder(): Builder|null;
}
