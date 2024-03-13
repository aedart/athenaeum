<?php

namespace Aedart\Tests\Helpers\Dummies\Core\Exceptions\Handlers;

use Aedart\Core\Exceptions\Handlers\BaseExceptionHandler;
use Aedart\Tests\Helpers\Dummies\Core\Exceptions\CriticalException;
use Throwable;
use UnexpectedValueException;

/**
 * Fails Handling
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Core\Exceptions\Handlers
 */
class FailsHandling extends BaseExceptionHandler
{
    /**
     * @inheritDoc
     */
    public function handle(Throwable $exception): bool
    {
        if ($exception instanceof UnexpectedValueException) {
            // (Re)throw this exception - in a real life application,
            // a handler could contain very complex logic that might
            // produce some kind of error. Here, we simulate such
            // behaviour...
            throw new CriticalException('Testing failure of handler');
        }

        return false;
    }
}
