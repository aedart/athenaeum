<?php


namespace Aedart\Utils\Helpers;

use RuntimeException;
use Throwable;

/**
 * Invoker
 *
 * Callback invoke utility.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Utils\Helpers
 */
class Invoker
{
    /**
     * The callback to invoke
     *
     * @var mixed
     */
    protected mixed $callback;

    /**
     * Fallback callback to invoke, if
     * primary callback is not callable
     *
     * @var mixed
     */
    protected mixed $fallback = null;

    /**
     * Arguments to be passed on to callback
     *
     * @var array
     */
    protected array $arguments = [];

    /**
     * Invoker constructor.
     *
     * @param mixed $callback
     */
    public function __construct(mixed $callback)
    {
        $this->callback = $callback;
    }

    /**
     * Creates a new invoker instance with given callback
     *
     * @param mixed $callback
     *
     * @return static
     */
    public static function invoke(mixed $callback): static
    {
        return new static($callback);
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
     * Add arguments that must be passed to callback
     *
     * Method merges given arguments with et. already added
     * arguments.
     *
     * @param mixed ...$arguments
     *
     * @return self
     */
    public function with(...$arguments): static
    {
        $this->arguments = array_merge(
            $this->arguments,
            $arguments
        );

        return $this;
    }

    /**
     * Returns the arguments
     *
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * Add fallback callback to be used, in case that given
     * callback is not callable
     *
     * @param mixed $callback
     *
     * @return self
     */
    public function fallback(mixed $callback): static
    {
        $this->fallback = $callback;

        return $this;
    }

    /**
     * Return evt. fallback callback
     *
     * @return mixed
     */
    public function getFallback(): mixed
    {
        return $this->fallback;
    }

    /**
     * Determine if a fallback callback has been set
     *
     * @return bool
     */
    public function hasFallback(): bool
    {
        return isset($this->fallback) && is_callable($this->fallback);
    }

    /**
     * Invokes the primary callback or fallback method
     *
     * If no fallback method is given, then this method will
     * fail.
     *
     * @return mixed
     *
     * @throws Throwable
     */
    public function call(): mixed
    {
        $arguments = $this->getArguments();

        if ($this->hasCallback()) {
            return $this->callCallback($this->getCallback(), $arguments);
        }

        if ($this->hasFallback()) {
            return $this->callCallback($this->getFallback(), $arguments);
        }

        throw new RuntimeException('Unable to invoke callback or fallback');
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
