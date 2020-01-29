<?php

namespace Aedart\Console\Providers;

use Aedart\Console\Registrars\Commands\Registrar as CommandRegistrar;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Support\Helpers\Console\ArtisanTrait;
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
    use ArtisanTrait;

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

        $registrar = new CommandRegistrar(
            $this->getArtisan(),
            $this->app
        );

        $registrar->registerCommands($commands);

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
