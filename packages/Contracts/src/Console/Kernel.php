<?php

namespace Aedart\Contracts\Console;

use Aedart\Contracts\Console\Input\LastInputAware;
use Aedart\Contracts\Console\Output\LastOutputAware;
use Illuminate\Contracts\Console\Kernel as LaravelConsoleKernel;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Console Kernel
 *
 * Adaptor between Laravel's Artisan Console application and
 * Athenaeum Core Application.
 *
 * @see \Illuminate\Contracts\Console\Kernel
 * @see \Aedart\Contracts\Core\Application
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Console
 */
interface Kernel extends LaravelConsoleKernel,
    CoreApplicationAware,
    LastInputAware,
    LastOutputAware
{
    /**
     * Set Laravel's Artisan Console Application instance
     *
     * @param \Illuminate\Console\Application $artisan
     *
     * @return self
     */
    public function setArtisan($artisan);

    /**
     * Returns Laravel's Artisan Console Application instance
     *
     * @return \Illuminate\Console\Application|null
     */
    public function getArtisan();

    /**
     * Handles an exception
     *
     * @param \Throwable $e
     * @param OutputInterface $output
     *
     * @return void
     */
    public function handleException(\Throwable $e, OutputInterface $output) : void ;
}
