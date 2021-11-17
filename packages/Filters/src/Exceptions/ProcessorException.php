<?php

namespace Aedart\Filters\Exceptions;

use Aedart\Contracts\Filters\Exceptions\ProcessorException as ProcessorExceptionInterface;
use Aedart\Contracts\Filters\Processor;
use RuntimeException;
use Throwable;

/**
 * Http Query Parameter Processor Exception
 *
 * @see \Aedart\Contracts\Filters\Exceptions\ProcessorException
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Filters\Exceptions
 */
class ProcessorException extends RuntimeException implements ProcessorExceptionInterface
{
    /**
     * The processor that caused this exception
     *
     * @var Processor|null
     */
    protected ?Processor $processor = null;

    /**
     * @inheritDoc
     */
    public static function make(
        Processor $processor,
        $message = "",
        $code = 0,
        Throwable $previous = null
    ) {
        return (new static($message, $code, $previous))
            ->setProcessor($processor);
    }

    /**
     * @inheritDoc
     */
    public function setProcessor(Processor $processor)
    {
        $this->processor = $processor;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function processor(): ?Processor
    {
        return $this->processor;
    }
}
