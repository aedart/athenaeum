<?php

namespace Aedart\Core\Exceptions\Handlers\Adaptors;

use Aedart\Contracts\Core\Exceptions\AdaptedExceptionHandler;
use Aedart\Contracts\Exceptions\ExceptionHandler as CoreExceptionHandler;
use Aedart\Core\Traits\ExceptionHandlerFactoryTrait;
use Throwable;

/**
 * Laravel Exception Handler
 *
 * Adapter between the Core Application's exception handler and Laravel's version.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Exceptions\Handlers\Adaptors
 */
class LaravelExceptionHandler implements AdaptedExceptionHandler
{
    use ExceptionHandlerFactoryTrait;

    /**
     * The Core exception handler
     *
     * @var CoreExceptionHandler|null
     */
    protected CoreExceptionHandler|null $coreHandler = null;

    /**
     * @inheritdoc
     */
    public function report(Throwable $e)
    {
        $this->handler()->report($e);
    }

    /**
     * @inheritdoc
     */
    public function shouldReport(Throwable $e)
    {
        return $this->handler()->shouldReport($e);
    }

    /**
     * @inheritdoc
     */
    public function render($request, Throwable $e): void
    {
        http_response_code(500);
        echo (string) $e;
    }

    /**
     * @inheritdoc
     */
    public function renderForConsole($output, Throwable $e)
    {
        $output->write("<error>{$e}</error>");
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Returns the Core Application's exception handler
     *
     * @return CoreExceptionHandler
     *
     * @throws Throwable
     */
    protected function handler(): CoreExceptionHandler
    {
        if (isset($this->coreHandler)) {
            return $this->coreHandler;
        }

        return $this->coreHandler = $this->getExceptionHandlerFactory()->make();
    }
}
