<?php

namespace Aedart\Core\Bootstrappers;

use Aedart\Contracts\Core\Application;
use Aedart\Contracts\Core\Helpers\CanBeBootstrapped;
use Aedart\Support\Helpers\Config\ConfigTrait;

/**
 * Register Application Aliases
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Bootstrappers
 */
class RegisterApplicationAliases implements CanBeBootstrapped
{
    use ConfigTrait;

    /**
     * @inheritDoc
     */
    public function bootstrap(Application $application): void
    {
        // Obtain the aliases that have been defined within the application
        // configuration and register them
        $aliases = $this->getConfig()->get('app.aliases', []);

        foreach ($aliases as $alias => $abstract) {
            $application->alias($abstract, $alias);
        }
    }
}
