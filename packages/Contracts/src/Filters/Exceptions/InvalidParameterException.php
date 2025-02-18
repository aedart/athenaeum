<?php

namespace Aedart\Contracts\Filters\Exceptions;

use Aedart\Contracts\Filters\Processor;
use Throwable;

/**
 * Invalid Parameter Exception
 *
 * Should be thrown whenever invalid http query parameters are received.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Filters\Exceptions
 */
interface InvalidParameterException extends ProcessorException
{
    /**
     * Creates a new invalid parameter exception, for the given
     * parameter and processor
     *
     * @param string $parameter
     * @param Processor $processor
     * @param string $message [optional]
     * @param int $code [optional]
     * @param Throwable|null $previous [optional]
     *
     * @return static
     */
    public static function forParameter(
        string $parameter,
        Processor $processor,
        string $message = "",
        int $code = 0,
        Throwable|null $previous = null
    );

    /**
     * Set the parameter that caused this exception
     *
     * @param string $parameter
     *
     * @return self
     */
    public function setParameter(string $parameter);

    /**
     * Get the parameter that caused this exception
     *
     * Method defaults to the parameter name that is specified on
     * the assigned processor - if a processor has been set and
     * no custom parameter is given
     *
     * @return string|null
     */
    public function parameter(): string|null;
}
