<?php

namespace Aedart\Core\Exceptions\Handlers;

use Throwable;

/**
 * Cleanup Handler
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Exceptions\Handlers
 */
abstract class CleanupHandler extends BaseExceptionHandler
{
    /**
     * @inheritDoc
     */
    public function handle(Throwable $exception): bool
    {
        $this->cleanup($exception);

        return false;
    }

    /**
     * Performs cleanup logic, but does NOT deal with the
     * given exception.
     *
     * @param Throwable $exception
     */
    abstract public function cleanup(Throwable $exception): void;
}
