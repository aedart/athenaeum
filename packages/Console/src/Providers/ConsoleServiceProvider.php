<?php

namespace Aedart\Console\Providers;

use Aedart\Support\Helpers\Config\ConfigTrait;
use Illuminate\Console\Application;
use Illuminate\Console\Events\ArtisanStarting;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use RuntimeException;

/**
 * Console Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Console\Providers
 */
class ConsoleServiceProvider extends ServiceProvider implements DeferrableProvider
{
    use ConfigTrait;

    /**
     * Bootstrap this service
     */
    public function boot()
    {
        $this
            ->publishConfig()
            ->registerAvailableCommands();
    }

    /**
     * @inheritdoc
     */
    public function when()
    {
        // Ensure that this provider does not triggered unless artisan
        // is starting
        return [
            ArtisanStarting::class
        ];
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Register commands available in configuration
     *
     * @return self
     *
     * @throws RuntimeException If no register command method available
     */
    protected function registerAvailableCommands()
    {
        $commands = $this->getConfig()->get('commands', []);

        Application::starting(function(Application $artisan) use($commands){
            $artisan->resolveCommands($commands);
        });

        return $this;
    }

    /**
     * Publish example configuration
     *
     * @return self
     */
    protected function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/../../configs/commands.php' => config_path('commands.php')
        ],'config');

        return $this;
    }
}
