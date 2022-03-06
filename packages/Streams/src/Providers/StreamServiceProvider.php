<?php

namespace Aedart\Streams\Providers;

use Aedart\Contracts\Streams\Meta\Repository as MetaRepositoryInterface;
use Aedart\Streams\Meta\Repository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Stream Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Providers
 */
class StreamServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->app->bind(MetaRepositoryInterface::class, function() {
            return new Repository();
        });
    }

    /**
     * @inheritDoc
     */
    public function provides()
    {
        return [
            MetaRepositoryInterface::class
        ];
    }
}
