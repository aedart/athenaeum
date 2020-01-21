<?php

namespace Aedart\Core\Exceptions\Handlers;

use Throwable;

/**
 * Null Exception Handler
 *
 * Intended for testing purposes or situations where an exception
 * handler is required, yet not supposed to do anything
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Exceptions\Handlers
 */
class NullExceptionHandler extends BaseExceptionHandler
{
    /**
     * @inheritDoc
     */
    public function handle(Throwable $exception): bool
    {
        return false;
    }
}
