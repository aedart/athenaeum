<?php

namespace Aedart\Antivirus\Providers;

use Aedart\Antivirus\DefaultUserResolver;
use Aedart\Antivirus\Events\FileWasScanned;
use Aedart\Contracts\Antivirus\Events\FileWasScanned as FileWasScannedInterface;
use Aedart\Contracts\Antivirus\Results\ScanResult;
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
    public function register()
    {
        $this->app->singleton(UserResolver::class, function () {
            return new DefaultUserResolver();
        });

        $this->app->bind(FileWasScannedInterface::class, function (Application $app, array $params) {
            $scanResult = $params['result'] ?? null;
            if (!isset($scanResult) || !($scanResult instanceof ScanResult)) {
                throw new BindingResolutionException('Unable to resolve File Was Scanned Event. Invalid "result" parameter');
            }

            return new FileWasScanned($params['result']);
        });
    }

    /**
     * @inheritDoc
     */
    public function provides()
    {
        return [
            UserResolver::class,
            FileWasScannedInterface::class
        ];
    }
}
