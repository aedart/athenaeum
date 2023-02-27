<?php

namespace Aedart\Antivirus\Scanners\Status;

use Aedart\Antivirus\Exceptions\UnsupportedStatusValue;
use Aedart\Antivirus\Results\BaseStatus;
use Xenolope\Quahog\Result as ClamAvDriverResult;

/**
 * Clam AV Scan Status
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Antivirus\Scanners\Status
 */
class ClamAvStatus extends BaseStatus
{
    /**
     * @inheritDoc
     */
    public function resolveValue(mixed $value): ClamAvDriverResult
    {
        if (!($value instanceof ClamAvDriverResult)) {
            throw new UnsupportedStatusValue(sprintf('Expected %s as value, received %s ', ClamAvDriverResult::class, gettype($value)));
        }

        return $value;
    }

    /**
     * @inheritDoc
     */
    public function isOk(): bool
    {
        return $this->value()->isOk();
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        /** @var ClamAvDriverResult $value */
        $value = $this->value();

        return match (true) {
            $value->isOk() => $this->valueWithReason('Clean'),
            $value->isFound() => $this->valueWithReason('Infected'),
            $value->isError() => $this->valueWithReason('Error'),
            default => $this->valueWithReason('Unknown'),
        };
    }
}
