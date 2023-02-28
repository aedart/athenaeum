<?php

namespace Aedart\Antivirus\Results;

use Aedart\Antivirus\Exceptions\UnsupportedStatusValue;

/**
 * Generic Status
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Antivirus\Scanners\Status
 */
class GenericStatus extends BaseStatus
{
    /**
     * @inheritDoc
     */
    public function resolveValue(mixed $value): bool
    {
        if (!is_bool($value)) {
            throw new UnsupportedStatusValue(sprintf('Value must be boolean, %s provided', gettype($value)));
        }

        return $value;
    }

    /**
     * @inheritDoc
     */
    public function isOk(): bool
    {
        return $this->value() === true;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        $value = $this->value()
            ? 'Passed'
            : 'Failed';

        return $this->valueWithReason($value);
    }
}
