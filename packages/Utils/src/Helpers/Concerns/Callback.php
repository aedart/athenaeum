<?php

namespace Aedart\Utils\Helpers\Concerns;

/**
 * Concerns Callback
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils\Helpers\Concerns
 */
trait Callback
{
    /**
     * The callback to be invoked
     *
     * @var callable|mixed
     */
    protected $callback = null;

    /**
     * Set the callback to be invoked
     *
     * @param  callable|mixed  $callback
     *
     * @return self
     */
    protected function setCallback(mixed $callback): static
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * Returns the callback
     *
     * @return mixed
     */
    public function getCallback(): mixed
    {
        return $this->callback;
    }

    /**
     * Determine if a callback was set and that it is callable
     *
     * @return bool
     */
    public function hasCallback(): bool
    {
        return isset($this->callback) && is_callable($this->callback);
    }

    /**
     * Calls the given callback with given arguments and returns its
     * resulting output
     *
     * @param callable $callback
     * @param array $arguments [optional]
     *
     * @return mixed
     */
    protected function callCallback(callable $callback, array $arguments = []): mixed
    {
        return $callback(...$arguments);
    }
}