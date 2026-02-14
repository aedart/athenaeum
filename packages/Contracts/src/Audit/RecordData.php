<?php

namespace Aedart\Contracts\Audit;

/**
 * Audit Trail Record Data
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Audit
 */
interface RecordData
{
    /**
     * Returns model's formatted original data
     *
     * @return array|null
     */
    public function original(): array|null;

    /**
     * Returns model's formatted changed data
     *
     * @return array|null
     */
    public function changed(): array|null;

    /**
     * Returns audit trail entry message
     *
     * @return array|null
     */
    public function message(): string|null;
}
