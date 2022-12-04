<?php

namespace Aedart\Streams\Providers;

use Aedart\Contracts\Streams\Locks\Factory as LockFactoryInterface;
use Aedart\Contracts\Streams\Meta\Repository as MetaRepositoryInterface;
use Aedart\Contracts\Streams\Transactions\Factory as TransactionFactoryInterface;
use Aedart\Streams\Locks\LockFactory;
use Aedart\Streams\Meta\Repository;
use Aedart\Streams\Transactions\TransactionFactory;
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
        $this->app->bind(MetaRepositoryInterface::class, function () {
            return new Repository();
        });

        $this->app->singleton(LockFactoryInterface::class, function () {
            $config = config();

            return new LockFactory(
                $config->get('streams.locks'),
                $config->get('streams.default_lock'),
            );
        });

        $this->app->singleton(TransactionFactoryInterface::class, function () {
            $config = config();

            return new TransactionFactory(
                $config->get('streams.transactions'),
                $config->get('streams.default_transaction'),
            );
        });
    }

    /**
     * Bootstrap this service
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../configs/streams.php' => config_path('streams.php')
        ], 'config');
    }

    /**
     * @inheritDoc
     */
    public function provides()
    {
        return [
            MetaRepositoryInterface::class,
            LockFactoryInterface::class,
            TransactionFactoryInterface::class
        ];
    }
}
