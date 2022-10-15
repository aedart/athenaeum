<?php

namespace Aedart\Http\Api;

use Aedart\Contracts\Http\Api\Registrar as RegistrarInterface;

/**
 * Api Resource Registrar
 *
 * @see \Aedart\Contracts\Http\Api\Registrar
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api
 */
class Registrar implements RegistrarInterface
{
    /**
     * The eloquent models and associated api resource
     * registry
     *
     * @var array
     */
    protected array $registry = [];

    /**
     * Creates a new registrar instance
     *
     * @param  array  $resources
     */
    public function __construct(array $resources = [])
    {
        $this->register($resources);
    }

    /**
     * @inheritDoc
     */
    public function register(array $resources): static
    {
        foreach ($resources as $model => $resource) {
            $this->set($model, $resource);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function set($model, $resource): static
    {
        $model = $this->resolveClassPath($model);
        $resource = $this->resolveClassPath($resource);

        $this->registry[$model] = $resource;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function has($model): bool
    {
        return isset($this->registry[$this->resolveClassPath($model)]);
    }

    /**
     * @inheritDoc
     */
    public function get($model): string|null
    {
        return $this->registry[$this->resolveClassPath($model)] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function findModelByType(string $type): string|null
    {
        foreach ($this->registry as $model => $resource) {
            if ($this->matchesType($resource, $type)) {
                return $model;
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function findResourceByType(string $type): string|null
    {
        foreach ($this->registry as $resource) {
            if ($this->matchesType($resource, $type)) {
                return $resource;
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function forget($model): bool
    {
        if ($this->has($model)) {
            unset($this->registry[$this->resolveClassPath($model)]);

            return true;
        }

        return false;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Determine if api resource matches given type
     *
     * @param  string  $resource Api Resource class path
     * @param  string  $type Resource type (singular or plural form)
     *
     * @return bool
     */
    protected function matchesType(string $resource, string $type): bool
    {
        // Create a new instance of the Api Resource so that we can
        // match it against given type.

        /** @var \Aedart\Http\Api\Resources\ApiResource $apiResource */
        $apiResource = $resource::make(null);

        return $apiResource->matchesType($type);
    }

    /**
     * Resolves the class path of given target
     *
     * @param  object|string  $target Class instance or string class path
     *
     * @return string Class path
     */
    protected function resolveClassPath(object|string $target): string
    {
        return is_string($target)
            ? $target
            : $target::class;
    }
}