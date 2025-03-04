<?php

namespace Aedart\Audit\Helpers;

use Aedart\Audit\Concerns\CallbackReason;

/**
 * Audit Callback
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Helpers
 */
class Callback
{
    use CallbackReason;

    /**
     * The callback to invoke
     *
     * @var callable
     */
    protected $callback;

    /**
     * Callback that resolves audit trail entry reason
     *
     * @var callable|null
     */
    protected $reason = null;

    /**
     * Creates a new callback instance
     *
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * Creates a new audit callback instance with given callback
     *
     * @param callable $callback
     *
     * @return Callback
     */
    public static function perform(callable $callback): static
    {
        return new static($callback);
    }

    /**
     * Set the audit trail message to be used
     *
     * @param string|callable|null $reason [optional] Message or callback that returns
     *                                     message when resolved.
     *
     * @return self
     */
    public function because(string|callable|null $reason = null): static
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Executes the audit callback
     *
     * @return mixed
     */
    public function execute(): mixed
    {
        $callbackReason = $this->callbackReason();

        // Obtain evt. previous set reason and register
        // the one from this audit callback.
        $previous = $callbackReason->get();
        $callbackReason->register($this->reason);

        // Invoke the audit callback, which may result in one or more
        // new audit trail entries being recorded.
        $callback = $this->callback;
        $result = $callback();

        // Clear the registered reason and restore previous, if one
        // was available.
        $callbackReason->register($previous);

        return $result;
    }
}
