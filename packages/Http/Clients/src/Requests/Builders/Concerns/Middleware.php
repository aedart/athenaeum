<?php

namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Container\ListResolver;
use Aedart\Contracts\Http\Clients\HttpClientAware;
use Aedart\Contracts\Http\Clients\Middleware as MiddlewareInterface;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Illuminate\Support\Collection;

/**
 * Concerns Middleware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Concerns
 */
trait Middleware
{
    /**
     * Collection of middleware
     *
     * @var Collection|null
     */
    protected ?Collection $middleware = null;

    /**
     * @inheritDoc
     */
    public function withMiddleware($middleware): Builder
    {
        if (!is_array($middleware)) {
            return $this->pushMiddleware($middleware);
        }

        // Resolve list of middleware
        $resolved = (new ListResolver())
            ->with([$this, 'setupMiddleware'])
            ->make($middleware);

        $this->middleware->push($resolved);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function prependMiddleware($middleware): Builder
    {
        $this->middleware->prepend(
            $this->resolveMiddleware($middleware)
        );

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function pushMiddleware($middleware): Builder
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
    public function withoutMiddleware(): Builder
    {
        $this->middleware = $this->makeMiddlewareCollation();

        return $this;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Resolve middleware instance
     *
     * @param string|MiddlewareInterface $middleware
     *
     * @return MiddlewareInterface
     */
    protected function resolveMiddleware($middleware): MiddlewareInterface
    {
        if (is_string($middleware)) {
            $middleware = $this->getContainer()->make($middleware);
        }

        return $this->setupMiddleware($middleware);
    }

    /**
     * Setup the provided middleware instance
     *
     * @param  MiddlewareInterface  $middleware
     *
     * @return MiddlewareInterface
     */
    protected function setupMiddleware(MiddlewareInterface $middleware): MiddlewareInterface
    {
        if ($middleware instanceof HttpClientAware) {
            $middleware->setHttpClient($this);
        }

        return $middleware;
    }

    /**
     * Creates a new middleware collection
     *
     * @param MiddlewareInterface[] $middleware
     *
     * @return Collection
     */
    protected function makeMiddlewareCollation(array $middleware = []): Collection
    {
        return new Collection($middleware);
    }
}
