<?php

namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Container\ListResolver;
use Aedart\Contracts\Http\Clients\Middleware as MiddlewareInterface;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Clients\Requests\Builders\HttpRequestBuilderAware;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;

/**
 * Concerns Middleware
 *
 * @see Builder
 * @see Builder::withMiddleware
 * @see Builder::prependMiddleware
 * @see Builder::pushMiddleware
 * @see Builder::hasMiddleware
 * @see Builder::getMiddleware
 * @see Builder::withoutMiddleware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Concerns
 */
trait Middleware
{
    /**
     * Collection of middleware
     *
     * @var Collection<MiddlewareInterface>|null
     */
    protected Collection|null $middleware = null;

    /**
     * @inheritDoc
     *
     * @throws BindingResolutionException
     */
    public function withMiddleware(array|string|MiddlewareInterface $middleware): static
    {
        if (!is_array($middleware)) {
            return $this->pushMiddleware($middleware);
        }

        // Resolve list of middleware
        $resolved = (new ListResolver())
            ->with([$this, 'setupMiddleware'])
            ->make($middleware);

        $this->middleware = $this->middleware->union($resolved);

        return $this;
    }

    /**
     * @inheritDoc
     *
     * @throws BindingResolutionException
     */
    public function prependMiddleware(string|MiddlewareInterface $middleware): static
    {
        $this->middleware->prepend(
            $this->resolveMiddleware($middleware)
        );

        return $this;
    }

    /**
     * @inheritDoc
     *
     * @throws BindingResolutionException
     */
    public function pushMiddleware(string|MiddlewareInterface $middleware): static
    {
        $this->middleware->push(
            $this->resolveMiddleware($middleware)
        );

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function hasMiddleware(): bool
    {
        return !empty($this->middleware);
    }

    /**
     * @inheritDoc
     */
    public function getMiddleware(): array
    {
        return $this->middleware->all();
    }

    /**
     * @inheritDoc
     */
    public function withoutMiddleware(): static
    {
        $this->middleware = $this->makeMiddlewareCollation();

        return $this;
    }

    /**
     * Configure the provided middleware instance
     *
     * @param  MiddlewareInterface  $middleware
     *
     * @return MiddlewareInterface
     */
    public function setupMiddleware(MiddlewareInterface $middleware): MiddlewareInterface
    {
        if ($middleware instanceof HttpRequestBuilderAware) {
            $middleware->setHttpRequestBuilder($this);
        }

        return $middleware;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Resolve middleware instance
     *
     * @param  class-string<MiddlewareInterface>|MiddlewareInterface  $middleware
     *
     * @return MiddlewareInterface
     *
     * @throws BindingResolutionException
     */
    protected function resolveMiddleware(string|MiddlewareInterface $middleware): MiddlewareInterface
    {
        if (is_string($middleware)) {
            $middleware = $this->getContainer()->make($middleware);
        }

        return $this->setupMiddleware($middleware);
    }

    /**
     * Creates a new middleware collection
     *
     * @param MiddlewareInterface[] $middleware
     *
     * @return Collection<MiddlewareInterface>
     */
    protected function makeMiddlewareCollation(array $middleware = []): Collection
    {
        return new Collection($middleware);
    }
}
