<?php

namespace Aedart\Audit\Helpers;

use Aedart\Contracts\Audit\CallbackReason;

/**
 * Audit Callback Reason
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Helpers
 */
class Reason implements CallbackReason
{
    /**
     * Callback that resolves audit trail entry reason
     *
     * @var callable|null
     */
    protected $reason = null;

    /**
     * @inheritdoc
     */
    public function register(string|callable|null $reason): static
    {
        $reason = is_string($reason)
            ? fn () => $reason
            : $reason;

        $this->reason = $reason;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function resolve($model, string $type): string|null
    {
        if (!$this->exists()) {
            return null;
        }

        $callback = $this->get();

        return $callback($model, $type);
    }

    /**
     * @inheritdoc
     */
    public function exists(): bool
    {
        return isset($this->reason);
    }

    /**
     * @inheritdoc
     */
    public function get(): callable|null
    {
        return $this->reason;
    }

    /**
     * @inheritdoc
     */
    public function clear(): static
    {
        $this->reason = null;

        return $this;
    }
}
