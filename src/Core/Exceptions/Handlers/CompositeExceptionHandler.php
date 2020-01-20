<?php

namespace Aedart\Core\Exceptions\Handlers;

use Aedart\Contracts\Exceptions\CompositeExceptionHandler as CompositeExceptionHandlerInterface;
use Aedart\Contracts\Exceptions\ExceptionHandler;
use Aedart\Support\Facades\IoCFacade;
use Psr\Log\LogLevel;
use Throwable;

/**
 * Composite Exception Handler
 *
 * Delegates captured exception to list of "leaf" exception handlers.
 *
 * @see \Aedart\Contracts\Exceptions\CompositeExceptionHandler
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Exceptions\Handlers
 */
class CompositeExceptionHandler extends BaseExceptionHandler implements CompositeExceptionHandlerInterface
{
    /**
     * List of "leaf" exception handlers
     *
     * @var ExceptionHandler[]
     */
    protected array $handlers = [];

    /**
     * CompositeExceptionHandler constructor.
     *
     * @throws Throwable
     */
    public function __construct()
    {
        $handlers = $this->getConfig()->get('exceptions.handlers', []);

        $this->setHandlers( $handlers );
    }


    /**
     * {@inheritDoc}
     *
     * <br />
     *
     * Delegates exception to list of "leaf" exception handlers.
     * If a handler returns true, then given exception is
     * considered handled. If not, it is passed on to next handler.
     *
     * @throws Throwable If no "leaf" handler was able to handle exception.
     *                   Or if a "leaf" handler fails!
     */
    public function handle(Throwable $exception): bool
    {
        $wasHandled = false;

        try {
            // Attempt to report exception, if required
            $this->report($exception);

            // Delegate exception until handled
            $wasHandled = $this->delegate($exception);
        } catch (Throwable $critical) {
            // A "leaf" exception handler contains one or more
            // errors - it failed for some reason. Therefore,
            // we must allow this exception to bubble upwards (sadly),
            // with enough information about both this exception.
            // Hopefully, the original exception has already been reported
            // at this point.
            $this->reportWithLevel($critical, LogLevel::CRITICAL);

            // Now we throw the "new" exception, hopefully allowing the
            // developer to take immediate action,...
            throw $critical;
        }

        // This means that no handler was able to handle the
        // exception. Thus, we must allow it to bubble upwards!
        if($wasHandled === false){
            throw $exception;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function dontReport(): array
    {
        $list = parent::dontReport();

        $handlers = $this->getHandlers();
        foreach ($handlers as $handler){
            $list = array_merge($list, $handler->dontReport());
        }

        return $list;
    }

    /**
     * @inheritDoc
     */
    public function addHandler($handler)
    {
        $this->handlers[] = $this->resolveHandler($handler);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setHandlers(array $handlers = [])
    {
        foreach ($handlers as $handler){
            $this->addHandler($handler);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getHandlers(): array
    {
        return $this->handlers;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Delegate given exception to "leaf" exception handlers
     *
     * The first handler to return true, will stop the process
     * and the exception is considered handled.
     *
     * @param Throwable $exception
     *
     * @return bool
     */
    protected function delegate(Throwable $exception) : bool
    {
        $handlers = $this->getHandlers();
        foreach ($handlers as $handler){
            if($handler->handle($exception) === true){
                return true;
            }
        }

        return false;
    }

    /**
     * Resolves the given exception handler
     *
     * @param string|ExceptionHandler $handler
     *
     * @return ExceptionHandler
     *
     * @throws LogicException If handler is invalid
     */
    protected function resolveHandler($handler) : ExceptionHandler
    {
        $resolved = $handler;
        if(is_string($handler)){
            $resolved = IoCFacade::tryMake($handler);
        }

        if( ! ($resolved instanceof ExceptionHandler)){
            throw new LogicException('Provided exception handler MUST be a valid class path. Handler MUST also inherit from \Aedart\Contracts\Exceptions\ExceptionHandler');
        }

        return $resolved;
    }
}
