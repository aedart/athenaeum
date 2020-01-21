<?php

namespace Aedart\Core\Bootstrappers;

use Aedart\Contracts\Core\Application;
use Aedart\Contracts\Core\Helpers\CanBeBootstrapped;

/**
 * Register Application Service Providers
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Bootstrappers
 */
class RegisterApplicationServiceProviders implements CanBeBootstrapped
{
    /**
     * @inheritDoc
     */
    public function bootstrap(Application $application): void
    {
        // This will ensure that all service providers that are
        // declared in "app.providers" are registered.
        // This implementation is exactly like the one found in
        // Laravel's "RegisterProviders"
        // @see https://github.com/laravel/framework/blob/6.x/src/Illuminate/Foundation/Bootstrap/RegisterProviders.php#L7
        $application->registerConfiguredProviders();
    }
}
