<?php


namespace Aedart\Exceptions\Handlers;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Throwable;

/**
 * Null Exception Handler
 *
 * Intended for testing purposes only!
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Exceptions\Handlers
 */
class NullExceptionHandler extends BaseExceptionHandler
{
    /**
     * @inheritDoc
     */
    public function handleException(Throwable $exception): void
    {
        return;
    }
}
