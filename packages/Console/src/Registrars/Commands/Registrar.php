<?php

namespace Aedart\Console\Registrars\Commands;

use Aedart\Console\Registrars\Commands\Strategies\AthenaeumStrategy;
use Aedart\Console\Registrars\Commands\Strategies\LaravelStrategy;
use Aedart\Console\Registrars\Commands\Strategies\RegisterStrategy;
use Aedart\Contracts\Console\Kernel;
use Aedart\Contracts\Support\Helpers\Console\ArtisanAware;
use Aedart\Contracts\Support\Helpers\Container\ContainerAware;
use Aedart\Support\Helpers\Console\ArtisanTrait;
use Aedart\Support\Helpers\Container\ContainerTrait;
use Illuminate\Contracts\Console\Kernel as LaravelConsoleKernel;
use Illuminate\Contracts\Container\Container;
use RuntimeException;

/**
 * Console Command Registrar
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Console\Registrars\Commands
 */
class Registrar implements ArtisanAware,
    ContainerAware
{
    use ArtisanTrait;
    use ContainerTrait;

    /**
     * Registrar constructor.
     *
     * @param LaravelConsoleKernel|null $artisan [optional]
     * @param Container|null $container [optional]
     */
    public function __construct(?LaravelConsoleKernel $artisan = null, ?Container $container = null)
    {
        $this
            ->setArtisan($artisan)
            ->setContainer($container);
    }

    /**
     * Register given list of commands
     *
     * @param string[]|\Symfony\Component\Console\Command\Command[] $commands List class paths or instances
     */
    public function registerCommands(array $commands = [])
    {
        // Skip if no commands given
        if(empty($commands)){
            return;
        }

        $strategy = $this->determineStrategy();
        $strategy->register($commands);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Determine what register strategy to use and return it
     *
     * @return RegisterStrategy
     *
     * @throws RuntimeException
     */
    protected function determineStrategy() : RegisterStrategy
    {
        $artisan = $this->getArtisan();
        $container = $this->getContainer();

        if($artisan instanceof LaravelConsoleKernel){
            return new LaravelStrategy($artisan, $container);
        }

        if($artisan instanceof Kernel){
            return new AthenaeumStrategy($artisan, $container);
        }

        throw new RuntimeException('Unable to register commands due to unknown Artisan instance');
    }
}
