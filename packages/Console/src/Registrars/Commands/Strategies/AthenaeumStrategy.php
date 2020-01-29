<?php

namespace Aedart\Console\Registrars\Commands\Strategies;

use Aedart\Contracts\Console\Kernel;

/**
 * Athenaeum Console Command Register Strategy
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Console\Registrars\Commands\Strategies
 */
class AthenaeumStrategy extends RegisterStrategy
{
    /**
     * @inheritDoc
     */
    public function register(array $commands): void
    {
        /** @var \Aedart\Contracts\Console\Kernel $artisan */
        $artisan = $this->getArtisan();

        $artisan->addCommands($commands);
    }
}
