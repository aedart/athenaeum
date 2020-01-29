<?php

namespace Aedart\Console\Registrars\Commands\Strategies;

use RuntimeException;

/**
 * Laravel Console Command Register Strategy
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Console\Registrars\Commands\Strategies
 */
class LaravelStrategy extends RegisterStrategy
{
    /**
     * {@inheritDoc}
     *
     * @throws RuntimeException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register(array $commands): void
    {
        /** @var \Illuminate\Foundation\Console\Kernel $artisan */
        $artisan = $this->getArtisan();
        $container = $this->getContainer();

        // Abort if provided artisan is unable to register commands
        if( ! method_exists($artisan, 'registerCommand')){
            throw new RuntimeException('Unable to register commands to console application. No register method available');
        }

        foreach ($commands as $command){
            /** @var \Symfony\Component\Console\Command\Command $command */
            $command = $container->make($command);

            $artisan->registerCommand($command);
        }
    }
}
