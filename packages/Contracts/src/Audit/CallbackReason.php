<?php

namespace Aedart\Contracts\Audit;

/**
 * Audit Callback Reason
 *
 * @template M of \Illuminate\Database\Eloquent\Model
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Helpers
 */
interface CallbackReason
{
    /**
     * Register a reason for the next audit trail entry
     *
     * @param string|null|callable(M, string): string $reason
     *
     * @return self
     */
    public function register(string|callable|null $reason): static;

    /**
     * Resolves an audit trail message (a reason), if one was specified
     *
     * @param M $model
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
     * @return null|callable(M, string): string
     */
    public function get(): callable|null;

    /**
     * Clear the current reason
     *
     * @return self
     */
    public function clear(): static;
}
