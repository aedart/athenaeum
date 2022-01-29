<?php

namespace Aedart\Filters\Providers;

use Aedart\Contracts\Filters\BuiltFiltersMap;
use Aedart\Filters\BuiltFilters;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Filters Service Provider
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Filters\Providers
 */
class FiltersServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $bindings = [
        BuiltFiltersMap::class => BuiltFilters::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [ BuiltFiltersMap::class ];
    }
}
