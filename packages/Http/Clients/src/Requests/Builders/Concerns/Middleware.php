<?php

namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Middleware as MiddlewareInterface;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Illuminate\Support\Collection;
use InvalidArgumentException;

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
            $middleware = [$middleware];
        }

        foreach ($middleware as $item) {
            $this->pushMiddleware($item);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function prependMiddleware($middleware): Builder
    {
        $middleware = $this->resolveMiddleware($middleware);

        $this->middleware->prepend($middleware);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function pushMiddleware($middleware): Builder
    {
        $middleware = $this->resolveMiddleware($middleware);

        $this->middleware->push($middleware);

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
        // Resolve via Service Container
        if (is_string($middleware)) {
            $middleware = $this->getContainer()->make($middleware);
        }

        // Fail if not a valid type
        if (!($middleware instanceof MiddlewareInterface)) {
            throw new InvalidArgumentException('Unable to resolve middleware. Please provide valid class path or instance.');
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
