<?php

namespace Aedart\Exceptions\Helpers;

use Aedart\Contracts\Exceptions\ExceptionHandler;
use Aedart\Exceptions\Handlers\DefaultExceptionHandler;
use Aedart\Support\Facades\IoCFacade;
use Illuminate\Config\Repository;

/**
 * @deprecated
 *
 * Builds Exception Handler Helper
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Exceptions\Helpers
 */
trait BuildsExceptionHandler
{
    /**
     * Creates exception handler instance
     *
     * @return ExceptionHandler
     */
    protected function buildExceptionHandler() : ExceptionHandler
    {
        // Obtain configuration if available
        /** @var Repository $config */
        $config = IoCFacade::tryMake('config', new Repository());

        // Obtain the exception handler from configuration or default to
        // a fallback exception handler class path
        $class = $config->get('exceptions.handler', $this->fallbackExceptionHandler());

        // Finally, create handler instance
        return IoCFacade::tryMake($class);
    }

    /**
     * Get class path to a fallback exception handler
     *
     * @return string
     */
    protected function fallbackExceptionHandler() : string
    {
        return DefaultExceptionHandler::class;
    }
}
