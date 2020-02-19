<?php

namespace Aedart\Core\Exceptions\Handlers;

use Throwable;

/**
 * Prints Exceptions - Exception Handler
 *
 * Intended for testing purposes only!
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Exceptions\Handlers
 */
class PrintsExceptions extends BaseExceptionHandler
{
    /**
     * @inheritDoc
     */
    public function handle(Throwable $exception): bool
    {
        if (function_exists('dump')) {
            dump($exception);
        } else {
            print (string) $exception;
        }

        return false;
    }
}
