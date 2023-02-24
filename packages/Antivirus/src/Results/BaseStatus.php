<?php

namespace Aedart\Antivirus\Results;

use Aedart\Contracts\Antivirus\Exceptions\UnsupportedStatusValueException;
use Aedart\Contracts\Antivirus\Results\Status;

/**
 * Base Status
 *
 * Abstraction for file san status.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Antivirus\Results
 */
abstract class BaseStatus implements Status
{
    /**
     * Value used to determine success status
     *
     * @var mixed
     */
    protected mixed $value;

    /**
     * Create a new file scan status instance
     *
     * @param mixed $value
     * @param string|null $reason [optional]
     *
     * @throws UnsupportedStatusValueException
     */
    public function __construct(
        mixed $value,
        protected string|null $reason = null
    ) {
        $this->value = $this->resolveValue($value);
    }

    /**
     * Resolve the value used to determine success status
     *
     * @param mixed $value
     *
     * @return mixed
     *
     * @throws UnsupportedStatusValueException
     */
    abstract public function resolveValue(mixed $value): mixed;

    /**
     * @inheritDoc
     */
    public static function make(mixed $value, string|null $reason = null): static
    {
        return new static($value, $reason);
    }

    /**
     * @inheritDoc
     */
    public function reason(): string|null
    {
        return $this->reason;
    }

    /**
     * @inheritDoc
     */
    public function hasReason(): bool
    {
        return isset($this->reason);
    }
}
