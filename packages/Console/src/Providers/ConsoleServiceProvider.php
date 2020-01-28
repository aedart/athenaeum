<?php

namespace Aedart\Console\Providers;

use Aedart\Contracts\Console\Kernel;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Support\Helpers\Console\ArtisanTrait;
use Illuminate\Console\Events\ArtisanStarting;
use Illuminate\Contracts\Console\Kernel as LaravelConsoleKernelInterface;
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
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function registerAvailableCommands()
    {
        $commands = $this->getConfig()->get('commands', []);

        $artisan = $this->getArtisan();
        if( ! ($artisan instanceof Kernel)){
            return $this->registerCommandsViaLaravelConsole($artisan, $commands);
        }

        $artisan->addCommands($commands);

        return $this;
    }

    /**
     * Register commands via given artisan instance
     *
     * @param LaravelConsoleKernelInterface $artisan
     * @param string[] $commands List of class paths
     *
     * @return self
     *
     * @throws RuntimeException If no register command method available
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function registerCommandsViaLaravelConsole(LaravelConsoleKernelInterface $artisan, array $commands)
    {
        // Abort if provided artisan is unable to register commands
        if( ! method_exists($artisan, 'registerCommand')){
            throw new RuntimeException('Unable to register commands to console application. No register method available');
        }

        /** @var \Illuminate\Foundation\Console\Kernel $artisan */

        foreach ($commands as $command){
            /** @var \Symfony\Component\Console\Command\Command $command */
            $command = $this->app->make($command);
            $artisan->registerCommand($command);
        }

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
