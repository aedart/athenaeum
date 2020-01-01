<?php

namespace Aedart\Exceptions\Handlers;

use Throwable;

/**
 * Default Exception Handler
 *
 * This default handler is only responsible for enabling reporting of
 * exceptions by logging them. You are highly encouraged to create your
 * own exception handler.
 *
 * @see \Aedart\Exceptions\Handlers\BaseExceptionHandler
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Exceptions\Handlers
 */
class DefaultExceptionHandler extends BaseExceptionHandler
{
    /**
     * @inheritDoc
     */
    public function handleException(Throwable $exception): void
    {
        throw $exception;
    }
}
