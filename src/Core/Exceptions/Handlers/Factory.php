<?php

namespace Aedart\Core\Exceptions\Handlers;

use Aedart\Contracts\Exceptions\CompositeExceptionHandler as CompositeExceptionHandlerInterface;
use Aedart\Contracts\Exceptions\ExceptionHandler;
use Aedart\Contracts\Exceptions\Factory as ExceptionHandlerFactory;
use Aedart\Contracts\Support\Helpers\Config\ConfigAware;
use Aedart\Support\Facades\IoCFacade;
use Aedart\Support\Helpers\Config\ConfigTrait;

/**
 * Exception Handler Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Exceptions\Handlers
 */
class Factory implements ExceptionHandlerFactory,
    ConfigAware
{
    use ConfigTrait;

    /**
     * @inheritDoc
     */
    public function make(): ExceptionHandler
    {
        $handler = $this->obtainCompositeHandler();

        // Determine if composite has been configure before.
        // This might happen if an exception has been handled
        // and another exception is raised, causing the handling
        // process again.
        $leafs = $handler->getHandlers();
        if(empty($leafs)){
            $handlers = $this->getConfig()->get('exceptions.handlers', []);
            $handler->setHandlers($handlers);
        }

        return $handler;
    }

    /**
     * Creates or obtains "composite" exception handler
     *
     * @return CompositeExceptionHandlerInterface
     */
    protected function obtainCompositeHandler() : CompositeExceptionHandlerInterface
    {
        return IoCFacade::tryMake(
            ExceptionHandler::class,
            new CompositeExceptionHandler()
        );
    }
}
