<?php

namespace Aedart\Tests\Helpers\Dummies\Service\Providers\Partials;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\Helpers\MessageBag;

/**
 * Provider State
 *
 * FOR TESTING ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Service\Providers\Partials
 */
trait ProviderState
{
    /**
     * State, true if this service provider has registered
     *
     * @var bool
     */
    public bool $hasRegistered = false;

    /**
     * State, true if this service provider has booted
     *
     * @var bool
     */
    public bool $hasBooted = false;

    /**
     * Register this service provider
     */
    public function register()
    {
        $this->hasRegistered = true;

        $this->logMessage(get_class($this) . ' has registered');
    }

    /**
     * Boot this service provider
     */
    public function boot()
    {
        $this->hasBooted = true;

        $this->logMessage(get_class($this) . ' has booted');
    }

    /**
     * Log a message for testing and debugging purposes
     *
     * @param string $message
     */
    protected function logMessage(string $message) : void
    {
        MessageBag::add($message);

        ConsoleDebugger::output($message);
    }
}
