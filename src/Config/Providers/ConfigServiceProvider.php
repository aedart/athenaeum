<?php

namespace Aedart\Config\Providers;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Config\Repository as RepositoryInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Config Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Providers
 */
class ConfigServiceProvider extends ServiceProvider
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        $key = 'config';

        $this->app->singleton($key, fn() => new Repository());

        $this->app->alias($key, RepositoryInterface::class);
        $this->app->alias($key, Repository::class);
    }
}
