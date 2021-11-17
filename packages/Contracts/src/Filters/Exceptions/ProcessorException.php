<?php

namespace Aedart\Contracts\Filters\Exceptions;

use Aedart\Contracts\Filters\Processor;
use Throwable;

/**
 * Http Query Parameter Processor Exception
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Filters\Exceptions
 */
interface ProcessorException extends Throwable
{
    /**
     * Creates a new exception instance with processor assigned
     *
     * @param Processor $processor
     * @param string $message [optional]
     * @param int $code [optional]
     * @param Throwable|null $previous [optional]
     *
     * @return static
     */
    public static function make(
        Processor $processor,
        $message = "",
        $code = 0,
        Throwable $previous = null
    );

    /**
     * Set the processor that caused this exception
     *
     * @param Processor $processor
     *
     * @return self
     */
    public function setProcessor(Processor $processor);

    /**
     * Get the processor that caused this exception
     *
     * @return Processor|null
     */
    public function processor(): ?Processor;
}
