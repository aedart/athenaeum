<?php

namespace Aedart\Contracts\Core\Helpers;

use Aedart\Contracts\Core\Application;

/**
 * Can Be Bootstrapped
 *
 * Component is able to perform some kind of "bootstrapping" logic
 *
 * Interface is inspired by Laravel's Foundation bootstrapper components.
 *
 * @see https://github.com/laravel/framework/tree/6.x/src/Illuminate/Foundation/Bootstrap
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Core\Helpers
 */
interface CanBeBootstrapped
{
    /**
     * Bootstrap the given application
     *
     * @param Application $application
     */
    public function bootstrap(Application $application) : void ;
}
