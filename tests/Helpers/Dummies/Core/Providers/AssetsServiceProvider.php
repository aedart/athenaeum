<?php

namespace Aedart\Tests\Helpers\Dummies\Core\Providers;

use Codeception\Configuration;
use Illuminate\Support\ServiceProvider;

/**
 * Assets Service Provider
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Core\Providers
 */
class AssetsServiceProvider extends ServiceProvider
{
    /**
     * Boot this provider
     *
     * @throws \Codeception\Exception\ConfigurationException
     */
    public function boot()
    {
        if( ! $this->app->runningUnitTests()){
            return;
        }

        $this->publishes([
            __DIR__ . '/../../../../../packages/Support/resources/' => Configuration::outputDir() . 'console/publish/',
        ],'resources');
    }
}
