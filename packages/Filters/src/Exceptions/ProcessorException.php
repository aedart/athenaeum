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
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Filters\Exceptions
 */
class ProcessorException extends RuntimeException implements ProcessorExceptionInterface
{
    /**
     * The processor that caused this exception
     *
     * @var Processor|null
     */
    protected Processor|null $processor = null;

    /**
     * @inheritDoc
     */
    public static function make(
        Processor $processor,
        string $message = "",
        int $code = 0,
        Throwable|null $previous = null
    ): static {
        return (new static($message, $code, $previous))
            ->setProcessor($processor);
    }

    /**
     * @inheritDoc
     */
    public function setProcessor(Processor $processor): static
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
