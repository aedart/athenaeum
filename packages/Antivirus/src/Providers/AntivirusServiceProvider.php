<?php

namespace Aedart\Antivirus\Providers;

use Aedart\Antivirus\DefaultUserResolver;
use Aedart\Antivirus\Events\FileWasScanned;
use Aedart\Antivirus\Results\Result;
use Aedart\Contracts\Antivirus\Events\FileWasScanned as FileWasScannedInterface;
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
            ->bindResultComponents();
    }

    /**
     * @inheritDoc
     */
    public function provides(): array
    {
        return [
            UserResolver::class,
            FileWasScannedInterface::class,
            ScanResult::class
        ];
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

            if (!isset($params['filename'])) {
                throw new BindingResolutionException('"filename" argument is required for Scan Result');
            }

            if (!isset($params['filesize'])) {
                throw new BindingResolutionException('"filesize" argument is required for Scan Result');
            }

            return new Result(
                status: $params['status'],
                filename: $params['filename'],
                filesize: $params['filesize'],
                details: $params['details'] ?? null,
                user: $params['user'] ?? null,
                datetime: $params['datetime'] ?? null
            );
        });

        return $this;
    }
}
