<?php

namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Http\Clients\Middleware\AppliesResponseExpectations;
use Aedart\Http\Clients\Requests\Builders\ProcessedOptions;

/**
 * Applies Expectations
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes
 */
class AppliesExpectations
{
    /**
     * Middleware to assign
     *
     * @var string
     */
    protected string $middleware = AppliesResponseExpectations::class;

    /**
     * Request Builder instance
     *
     * @var Builder
     */
    protected Builder $builder;

    /**
     * Applies the {@see AppliesResponseExpectations} middleware, if required
     *
     * @param ProcessedOptions $processed
     * @param mixed $next
     *
     * @return mixed
     */
    public function handle(ProcessedOptions $processed, $next)
    {
        $this->builder = $builder = $processed->builder();

        // Continue, if no response expectations assigned or middleware
        // has already been assigned.
        if (!$builder->hasExpectations() || $this->hasResponseExpectationsMiddleware()) {
            return $next($processed);
        }

        // Add middleware in the beginning of the list. Expectations SHOULD be performed
        // as soon as a response is available.
        $builder->prependMiddleware($this->middleware);

        // Continue...
        return $next($processed);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Determine whether or not the response expectations middleware
     * has already been assigned to the Http Client
     *
     * @return bool
     */
    protected function hasResponseExpectationsMiddleware(): bool
    {
        $list = $this->builder->getMiddleware();

        foreach ($list as $middleware) {
            if ($middleware instanceof $this->middleware) {
                return true;
            }
        }

        return false;
    }
}
