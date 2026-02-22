<?php

namespace Aedart\Container;

use Aedart\Contracts\Container\ListResolver as Resolver;
use Aedart\Contracts\Support\Helpers\Container\ContainerAware;
use Aedart\Support\Helpers\Container\ContainerTrait;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;

/**
 * List Resolver
 *
 * @see \Aedart\Contracts\Container\ListResolver
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Container
 */
class ListResolver implements
    Resolver,
    ContainerAware
{
    use ContainerTrait;

    /**
     * Callback to be applied for each resolved instance.
     *
     * @template R of mixed Resolve Instance
     *
     * @var null|callable(R $instance): R
     */
    protected $callback = null;

    /**
     * DependenciesResolver constructor.
     *
     * @param  Container|null  $container  [optional]
     */
    public function __construct(Container|null $container = null)
    {
        $this->setContainer($container);
    }

    /**
     * @inheritDoc
     */
    public function make(array $dependencies): array
    {
        $resolved = [];

        foreach ($dependencies as $key => $value) {
            $resolved[] = $this->resolve($key, $value);
        }

        return $resolved;
    }

    /**
     * @inheritDoc
     */
    public function with(callable $callback): static
    {
        $this->callback = $callback;

        return $this;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Resolve given key-value pair
     *
     * @param  class-string|int  $key  String class path or array index, in which
     *                        case it will be ignored
     * @param  mixed  $value  String class path or instance arguments.
     *
     * @return mixed Resolved instance
     *
     * @throws BindingResolutionException
     */
    protected function resolve(string|int $key, mixed $value): mixed
    {
        $target = $value;
        $arguments = null;
        $callback = $this->callback ?? [$this, 'defaultCallback'];

        // In case that key is class path, set target to match the key.
        if (is_string($key)) {
            $target = $key;
            $arguments = $value;
        }

        // If given target is already a created instance, pass it on
        // to the callback.
        if (is_object($target)) {
            return $callback($target);
        }

        // Arguments might have been provided. If so, we must ensure that
        // there are formatted as an array. This will allow the Service
        // Container to apply them to the constructor.
        if (isset($arguments) && !is_array($arguments)) {
            $arguments = [$arguments];
        }

        // Default to empty array, in case that no arguments have been given
        $arguments = $arguments ?? [];

        // Finally, resolve target and invoke provided callback.
        return $callback(
            $this->getContainer()->make($target, $arguments)
        );
    }

    /**
     * Default callback to be invoked, when none provided.
     *
     * @param  mixed  $instance
     *
     * @return mixed
     */
    protected function defaultCallback(mixed $instance): mixed
    {
        return $instance;
    }
}
