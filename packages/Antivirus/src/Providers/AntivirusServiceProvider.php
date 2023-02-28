<?php

namespace Aedart\Antivirus\Providers;

use Aedart\Antivirus\DefaultUserResolver;
use Aedart\Antivirus\Events\FileWasScanned;
use Aedart\Antivirus\Manager;
use Aedart\Antivirus\Results\Result;
use Aedart\Contracts\Antivirus\Events\FileWasScanned as FileWasScannedInterface;
use Aedart\Contracts\Antivirus\Manager as AntivirusManager;
use Aedart\Contracts\Antivirus\Results\ScanResult;
use Aedart\Contracts\Antivirus\Results\Status;
use Aedart\Contracts\Antivirus\UserResolver;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Antivirus Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Antivirus\Providers
 */
class AntivirusServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @inheritdoc
     */
    public function register(): void
    {
        $this
            ->bindUserResolver()
            ->bindEvents()
            ->bindResultComponents()
            ->bindManager();
    }

    /**
     * Boots this service provider
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../configs/antivirus.php' => $this->app->configPath('antivirus.php')
        ], 'config');

        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'athenaeum');
        $this->publishes([
            __DIR__ . '/../../lang' => $this->app->langPath('vendor/athenaeum'),
        ], 'lang');
    }

    /**
     * @inheritDoc
     */
    public function provides(): array
    {
        return [
            UserResolver::class,
            FileWasScannedInterface::class,
            ScanResult::class,
            AntivirusManager::class
        ];
    }

    /**
     * Binds antivirus manager
     *
     * @return self
     */
    protected function bindManager(): static
    {
        $this->app->singleton(AntivirusManager::class, function (Application $app) {
            $dispatcher = $app->make('events');
            $config = $app->make('config');

            return new Manager($dispatcher, $config);
        });

        return $this;
    }

    /**
     * Binds user resolver
     *
     * @return self
     */
    protected function bindUserResolver(): static
    {
        $this->app->singleton(UserResolver::class, function () {
            return new DefaultUserResolver();
        });

        return $this;
    }

    /**
     * Binds antivirus related events
     *
     * @return self
     */
    protected function bindEvents(): static
    {
        $this->app->bind(FileWasScannedInterface::class, function (Application $app, array $params) {
            $scanResult = $params['result'] ?? null;
            if (!isset($scanResult) || !($scanResult instanceof ScanResult)) {
                throw new BindingResolutionException('Invalid "result" provided for File Was Scanned Event');
            }

            return new FileWasScanned($params['result']);
        });

        return $this;
    }

    /**
     * Binds scan results related components
     *
     * @return self
     */
    protected function bindResultComponents(): static
    {
        $this->app->bind(ScanResult::class, function (Application $app, array $params) {
            if (!isset($params['status']) || !($params['status'] instanceof Status)) {
                throw new BindingResolutionException('Invalid "status" provided for Scan Result');
            }

            if (!isset($params['filepath'])) {
                throw new BindingResolutionException('"filepath" argument is required for Scan Result');
            }

            if (!isset($params['filesize'])) {
                throw new BindingResolutionException('"filesize" argument is required for Scan Result');
            }

            return new Result(
                status: $params['status'],
                filepath: $params['filepath'],
                filesize: $params['filesize'],
                filename: $params['filename'] ?? null,
                details: $params['details'] ?? null,
                user: $params['user'] ?? null,
                datetime: $params['datetime'] ?? null
            );
        });

        return $this;
    }
}
