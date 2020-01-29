<?php

namespace Aedart\Console\Registrars\Commands\Strategies;

use Aedart\Contracts\Support\Helpers\Console\ArtisanAware;
use Aedart\Contracts\Support\Helpers\Container\ContainerAware;
use Aedart\Support\Helpers\Console\ArtisanTrait;
use Aedart\Support\Helpers\Container\ContainerTrait;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Contracts\Container\Container;

/**
 * Console Command Register Strategy
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Console\Registrars\Commands\Strategies
 */
abstract class RegisterStrategy implements ArtisanAware,
    ContainerAware
{
    use ArtisanTrait;
    use ContainerTrait;

    /**
     * RegisterStrategy constructor.
     *
     * @param Kernel|null $artisan [optional]
     * @param Container|null $container [optional]
     */
    public function __construct(?Kernel $artisan = null, ?Container $container = null)
    {
        $this
            ->setArtisan($artisan)
            ->setContainer($container);
    }

    /**
     * Register console commands
     *
     * @param string[]|\Symfony\Component\Console\Command\Command[] $commands List class paths or instances
     */
    abstract public function register(array $commands) : void ;
}
