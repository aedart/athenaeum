<?php

namespace Aedart\Http\Api\Providers;

use Aedart\Contracts\Http\Api\Registrar as RegistrarInterface;
use Aedart\ETags\Providers\ETagsServiceProvider;
use Aedart\Http\Api\Registrar;
use Aedart\Http\Api\Traits\ApiResourceRegistrarTrait;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Illuminate\Support\AggregateServiceProvider;
use Illuminate\Support\ServiceProvider;

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
