<?php


namespace Aedart\Utils\Helpers;

use Aedart\Utils\Helpers\Concerns;
use RuntimeException;
use Throwable;

/**
 * Invoker
 *
 * Callback invoke utility.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils\Helpers
 */
class Invoker
{
    use Concerns\Callback;
    use Concerns\Arguments;

    /**
     * Fallback callback to invoke, if
     * primary callback is not callable
     *
     * @var callable|mixed
     */
    protected mixed $fallback = null;

    /**
     * Invoker constructor.
     *
     * @param callable $callback
     */
    public function __construct(mixed $callback)
    {
        $this->setCallback($callback);
    }

    /**
     * Creates a new invoker instance with given callback
     *
     * @param callable|mixed $callback
     *
     * @return static
     */
    public static function invoke(mixed $callback): static
    {
        return new static($callback);
    }

    /**
     * Add fallback callback to be used, in case that given
     * callback is not callable
     *
     * @param callable|mixed $callback
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
     * @return callable|mixed
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
}
