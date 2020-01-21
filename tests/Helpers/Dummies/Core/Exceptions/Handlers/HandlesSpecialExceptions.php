<?php

namespace Aedart\Tests\Helpers\Dummies\Core\Exceptions\Handlers;

use Aedart\Core\Exceptions\Handlers\BaseExceptionHandler;
use Aedart\Tests\Helpers\Dummies\Core\Exceptions\SpecialException;
use Throwable;

/**
 * Handles Special Exceptions
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Core\Exceptions\Handlers
 */
class HandlesSpecialExceptions extends BaseExceptionHandler
{
    /**
     * @inheritDoc
     */
    public function handle(Throwable $exception): bool
    {
        if($exception instanceof SpecialException){
            dump('special exception handled');

            return true;
        }

        return false;
    }
}
