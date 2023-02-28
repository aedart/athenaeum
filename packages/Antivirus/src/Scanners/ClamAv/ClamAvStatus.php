<?php

namespace Aedart\Antivirus\Scanners\ClamAv;

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
     * Determine if ClamAV found infection in file
     *
     * @return bool
     */
    public function hasInfection(): bool
    {
        return $this->value()->isFound();
    }

    /**
     * Determine if an error occurred during scanning
     *
     * @return bool
     */
    public function hasError(): bool
    {
        return $this->value()->isError();
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return match (true) {
            $this->isOk() => $this->valueWithReason('Clean'),
            $this->hasInfection() => $this->valueWithReason('Infected'),
            $this->hasError() => $this->valueWithReason('Error'),
            default => $this->valueWithReason('Unknown'),
        };
    }
}
