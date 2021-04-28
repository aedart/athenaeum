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
     * @var callable|mixed
     */
    protected $callback;

    /**
     * Fallback callback to invoke, if
     * primary callback is not callable
     *
     * @var callable|mixed
     */
    protected $fallback = null;

    /**
     * Arguments to be passed on to callback
     *
     * @var array
     */
    protected array $arguments = [];

    /**
     * Invoker constructor.
     *
     * @param callable|mixed $callback
     */
    public function __construct($callback)
    {
        $this->callback = $callback;
    }

    /**
     * Creates a new invoker instance with given callback
     *
     * @param callable|mixed $callback
     *
     * @return static
     */
    public static function invoke($callback): Invoker
    {
        return new static($callback);
    }

    /**
     * Returns the callback
     *
     * @return callable|mixed
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * Add arguments that must be passed to callback
     *
     * Method merges given arguments with et. already added
     * arguments.
     *
     * @param ...$arguments
     *
     * @return self
     */
    public function with(...$arguments): self
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
     * @param callable|mixed $callback
     *
     * @return self
     */
    public function fallback($callback): self
    {
        $this->fallback = $callback;

        return $this;
    }

    /**
     * Return evt. fallback callback
     *
     * @return callable|mixed
     */
    public function getFallback()
    {
        return $this->fallback;
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
    public function call()
    {
        $arguments = $this->getArguments();

        $callback = $this->getCallback();
        if (is_callable($callback)) {
            return $this->callCallback($callback, $arguments);
        }

        $fallback = $this->getFallback();
        if (isset($fallback) && is_callable($fallback)) {
            return $this->callCallback($fallback, $arguments);
        }

        throw new RuntimeException('Unable to invoke callback or fallback');
    }

    /**
     * Calls the given callback with given arguments and returns it's
     * resulting output
     *
     * @param callable $callback
     * @param array $arguments [optional]
     *
     * @return mixed
     */
    protected function callCallback(callable $callback, array $arguments = [])
    {
        return $callback(...$arguments);
    }
}
