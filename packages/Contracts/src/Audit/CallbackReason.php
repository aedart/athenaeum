<?php

namespace Aedart\Contracts\Audit;

/**
 * Audit Callback Reason
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Helpers
 */
interface CallbackReason
{
    /**
     * Register a reason for the next audit trail entry
     *
     * @param string|callable|null $reason
     *
     * @return self
     */
    public function register(string|callable|null $reason): static;

    /**
     * Resolves an audit trail message (a reason), if one was specified
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $type
     *
     * @return string|null
     */
    public function resolve($model, string $type): string|null;

    /**
     * Determine if a reason exists
     *
     * @return bool
     */
    public function exists(): bool;

    /**
     * Returns the reason callback, if any was registered
     *
     * @return callable|null
     */
    public function get(): callable|null;

    /**
     * Clear the current reason
     *
     * @return self
     */
    public function clear(): static;
}
