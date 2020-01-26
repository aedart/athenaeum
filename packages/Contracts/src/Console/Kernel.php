<?php

namespace Aedart\Contracts\Console;

use Aedart\Contracts\Core\ApplicationAware;
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
    ApplicationAware
{

}
