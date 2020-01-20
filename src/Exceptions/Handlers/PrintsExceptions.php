<?php


namespace Aedart\Exceptions\Handlers;

use Throwable;

/**
 * @deprecated
 *
 * Prints Exceptions - Exception Handler
 *
 * Intended for testing purposes only
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Exceptions\Handlers
 */
class PrintsExceptions extends BaseExceptionHandler
{

    /**
     * @inheritDoc
     */
    public function handleException(Throwable $exception): void
    {
        dump($exception);
    }
}
