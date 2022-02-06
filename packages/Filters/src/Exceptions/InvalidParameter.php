<?php

namespace Aedart\Filters\Exceptions;

use Aedart\Contracts\Filters\Exceptions\InvalidParameterException;
use Aedart\Contracts\Filters\Processor;
use Throwable;

/**
 * Invalid Parameter
 *
 * @see \Aedart\Contracts\Filters\Exceptions\InvalidParameterException
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Filters\Exceptions
 */
class InvalidParameter extends ProcessorException implements InvalidParameterException
{
    /**
     * The parameter in question
     *
     * @var string|null
     */
    protected ?string $param = null;

    /**
     * @inheritDoc
     */
    public static function forParameter(
        string $parameter,
        Processor $processor,
        string $message = "",
        int $code = 0,
        Throwable|null $previous = null
    ): static
    {
        return static::make($processor, $message, $code, $previous)
            ->setParameter($parameter);
    }

    /**
     * @inheritDoc
     */
    public function setParameter(string $parameter): static
    {
        $this->param = $parameter;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function parameter(): ?string
    {
        if (isset($this->param)) {
            return $this->param;
        }

        return optional($this->processor())->parameter() ?? 'query';
    }
}
