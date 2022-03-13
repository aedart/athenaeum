<?php

namespace Aedart\MimeTypes\Providers;

use Aedart\Contracts\MimeTypes\Detector as DetectorInterface;
use Aedart\MimeTypes\Detector;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Mime-Types Detection Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\MimeTypes\Providers
 */
class MimeTypesDetectionServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->app->singleton(DetectorInterface::class, function() {
            $config = config();

            return new Detector(
                $config->get('mime-types-detection.detectors'),
                $config->get('mime-types-detection.default'),
            );
        });
    }

    /**
     * Bootstrap this service
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../configs/mime-types-detection.php' => config_path('mime-types-detection.php')
        ], 'config');
    }

    /**
     * @inheritDoc
     */
    public function provides()
    {
        return [
            DetectorInterface::class
        ];
    }
}
