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
    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->app->bind(BuiltFiltersMap::class, function () {
            return new BuiltFilters();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [ BuiltFiltersMap::class ];
    }
}
