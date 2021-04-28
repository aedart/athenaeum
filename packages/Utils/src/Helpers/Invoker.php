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
     * @var callable|null
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
     * Add arguments that must be passed to callback
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
        if (is_callable($this->callback)) {
            $callback = $this->callback;
        } elseif (isset($this->fallback) && is_callable($this->fallback)) {
            $callback = $this->fallback;
        } else {
            throw new RuntimeException('Unable to invoke callback or fallback');
        }

        return $callback(...$this->arguments);
    }
}