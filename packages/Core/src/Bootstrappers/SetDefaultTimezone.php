<?php

namespace Aedart\Core\Bootstrappers;

use Aedart\Contracts\Core\Application;
use Aedart\Contracts\Core\Helpers\CanBeBootstrapped;
use Aedart\Support\Helpers\Config\ConfigTrait;

/**
 * Set Default Timezone
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Bootstrappers
 */
class SetDefaultTimezone implements CanBeBootstrapped
{
    use ConfigTrait;

    /**
     * @inheritDoc
     */
    public function bootstrap(Application $application): void
    {
        date_default_timezone_set( $this->getConfig()->get('app.timezone', 'UTC') );
    }
}
