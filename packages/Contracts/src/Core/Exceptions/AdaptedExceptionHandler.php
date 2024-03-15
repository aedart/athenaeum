<?php

namespace Aedart\Contracts\Core\Exceptions;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Throwable;

/**
 * Adapted Exception Handler
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Core\Exceptions
 */
interface AdaptedExceptionHandler extends ExceptionHandler
{
    /**
     * Overwritten {@see ExceptionHandler::render} that does NOT return.
     *
     * @param $request
     * @param Throwable $e
     *
     * @return void
     */
    public function render($request, Throwable $e): void;
}
