<?php

namespace Aedart\Exceptions\Handlers;

use Aedart\Contracts\Exceptions\ExceptionHandler;
use Aedart\Contracts\Support\Helpers\Logging\LogAware;
use Aedart\Support\Facades\IoCFacade;
use Aedart\Support\Helpers\Logging\LogTrait;
use Psr\Log\LoggerInterface;
use Throwable;

/**
 * Base Exception Handler
 *
 * Abstraction offers a few common methods for dealing with exceptions.
 *
 * @see \Aedart\Contracts\Exceptions\ExceptionHandler
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Exceptions\Handlers
 */
abstract class BaseExceptionHandler implements ExceptionHandler,
    LogAware
{
    use LogTrait;

    /**
     * List of exception that should not be reported
     *
     * @var string[] Class paths
     */
    protected array $dontReport = [];

    /*****************************************************************
     * Abstractions
     ****************************************************************/

    /**
     * Handle given exception
     *
     * Method is responsible for performing domain specific exception
     * handling, if required.
     *
     * SHOULD NOT attempt to report (e.g. log) exception, since this
     * is handled outside scope of this method - unless exception
     * requires additional reporting.
     *
     * Should the exception require a Http response or other form
     * of output, then the method SHOULD assign it as the next
     * response, using whatever mechanism is being used by the
     * application. In other words, this method SHOULD NOT send
     * output directly!
     *
     * @see handle
     *
     * @param Throwable $exception
     *
     * @return void
     *
     * @throws Throwable If unable to handle exception.
     */
    abstract public function handleException(Throwable $exception) : void ;

    /*****************************************************************
     * Common methods
     ****************************************************************/

    /**
     * @inheritDoc
     */
    public function handle(Throwable $exception): void
    {
        // Attempt to report exception, if required
        $this->report($exception);

        // Defer to actual handling
        $this->handleException($exception);
    }

    /**
     * @inheritDoc
     */
    public function shouldReport(Throwable $exception): bool
    {
        $dontReportList = $this->dontReport();
        foreach ($dontReportList as $exceptionNotToReport){
            if($exception instanceof $exceptionNotToReport){
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function dontReport(): array
    {
        return $this->dontReport;
    }

    /**
     * @inheritDoc
     */
    public function report(Throwable $exception): void
    {
        if( ! $this->shouldReport($exception)){
            return;
        }

        // Abort if no logger is available.
        $logger = $this->getLog();
        if( ! isset($logger)){
            return;
        }

        // Try to build a context for given exception
        try {
            $context = $this->makeReportContext($exception);
        } catch (Throwable $e){
            // For whatever reason we are not able to build a context
            // for the given exception. We log a message about this,
            // and build a default content.
            $logger->warning('Unable to build exception context. Failure detected inside exception handler',
                             [ 'exception' => $e ]);

            $context = [ 'exception-throw' => get_class($exception) ];
        }

        // Finally, log the exception as "error" severity
        $logger->error($exception->getMessage(), $context);
    }

    /*****************************************************************
     * Defaults
     ****************************************************************/

    /**
     * @inheritdoc
     */
    public function getDefaultLog(): ?LoggerInterface
    {
        // The default log-aware uses Laravel's log facade,
        // which will fail in case it's not bound.
        return IoCFacade::tryMake('log');
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Builds a "context" for given exception which should be used
     * when reporting it.
     *
     * @param Throwable $exception
     *
     * @return array
     */
    protected function makeReportContext(Throwable $exception) : array
    {
        return [
            'exception' => $exception
        ];
    }
}
