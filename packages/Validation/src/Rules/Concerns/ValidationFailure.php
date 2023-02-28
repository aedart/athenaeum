<?php

namespace Aedart\Validation\Rules\Concerns;

use Aedart\Contracts\Validation\FailedState;

/**
 * @deprecated Since 7.4 - Will be removed in next major version
 *
 * Concerns Validation Failure
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Validation\Rules\Concerns
 */
trait ValidationFailure
{
    /**
     * The failure state of this validation rule
     *
     * @var FailedState|null
     */
    protected FailedState|null $failedState = null;

    /**
     * Set the failure state of this validation rule
     *
     * @param FailedState|null $state
     *
     * @return self
     */
    public function setFailedState(FailedState|null $state): static
    {
        $this->failedState = $state;

        return $this;
    }

    /**
     * Get the failure state of this validation rule
     *
     * @return FailedState|null
     */
    public function getFailedState(): FailedState|null
    {
        return $this->failedState;
    }

    /**
     * Check if failure state has been set
     *
     * @return bool
     */
    public function hasFailedState(): bool
    {
        return isset($this->failedState);
    }
}
