<?php

namespace Aedart\Contracts\Exceptions;

use Throwable;

/**
 * Exception Handler
 *
 * This exception handler is inspired by Laravel's version hereof.
 * However, unlike Laravel's version, this handler does NOT know anything
 * about how to render an exception for Http, console or other output formats.
 *
 * @see \Illuminate\Contracts\Debug\ExceptionHandler
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Exceptions
 */
interface ExceptionHandler
{
    /**
     * Handle given exception
     *
     * Method is responsible for handling the exception,
     * e.g. report / log it, send notifications, or perform other
     * domain specific logic.
     *
     * Should the exception require a Http response or other form
     * of output, then the method SHOULD assign it as the next
     * response, using whatever mechanism is being used by the
     * application. In other words, this method SHOULD NOT send
     * output directly!
     *
     * @param Throwable $exception
     *
     * @return void
     *
     * @throws Throwable If unable to handle exception.
     */
    public function handle(Throwable $exception) : void ;

    /**
     * Determine if given exception should be reported, e.g. logged
     *
     * @see dontReport
     *
     * @param Throwable $exception
     *
     * @return bool
     */
    public function shouldReport(Throwable $exception) : bool ;

    /**
     * Returns a list of exceptions that this handler does not
     * wish to report
     *
     * @return Throwable[]|string[]
     */
    public function dontReport() : array ;

    /**
     * Report given exception, e.g. log exception or send notification
     *
     * Method must respect not to report exceptions that are marked
     * as "do not report".
     *
     * @see shouldReport
     * @see dontReport
     *
     * @param Throwable $exception
     *
     * @return void
     */
    public function report(Throwable $exception) : void ;
}
