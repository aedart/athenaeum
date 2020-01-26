<?php

namespace Aedart\Contracts\Console;

use Illuminate\Console\Application;
use Illuminate\Contracts\Console\Kernel as LaravelConsoleKernel;

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
    CoreApplicationAware
{
    /**
     * Set Laravel's Artisan Console Application instance
     *
     * @param \Illuminate\Console\Application $artisan
     *
     * @return void
     */
    public function setArtisan($artisan);

    /**
     * Returns Laravel's Artisan Console Application instance
     *
     * @return \Illuminate\Console\Application
     */
    public function getArtisan();
}
