<?php

namespace Aedart\Http\Api\Providers;

use Aedart\ETags\Providers\ETagsServiceProvider;
use Illuminate\Support\AggregateServiceProvider;

/**
 * Api Resource Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Providers
 */
class ApiResourceServiceProvider extends AggregateServiceProvider
{
    /**
     * List of providers
     *
     * @var array
     */
    protected $providers = [
        ETagsServiceProvider::class,
        JsonResourceServiceProvider::class
    ];
}
