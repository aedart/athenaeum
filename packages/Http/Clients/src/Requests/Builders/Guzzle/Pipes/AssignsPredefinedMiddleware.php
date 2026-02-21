<?php

namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes;

use Aedart\Contracts\Http\Clients\Middleware;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Http\Clients\Middleware\AppliesResponseExpectations;
use Aedart\Http\Clients\Middleware\RequestResponseDebugging;
use Aedart\Http\Clients\Middleware\RequestResponseLogging;
use Aedart\Http\Clients\Requests\Builders\ProcessedOptions;

/**
 * Assigns Predefined Middleware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes
 */
class AssignsPredefinedMiddleware
{
    /**
     * Predefined middleware to be assigned
     * Middleware is prepended in reverse order!
     *
     * @var array<class-string<Middleware>|Middleware>
     */
    protected array $middleware = [
        AppliesResponseExpectations::class,
        RequestResponseLogging::class,
        RequestResponseDebugging::class,
    ];

    /**
     * Request Builder instance
     *
     * @var Builder
     */
    protected Builder $builder;

    /**
     * Assigns a list of predefined middleware, if required
     *
     * @param ProcessedOptions $processed
     * @param mixed $next
     *
     * @return mixed
     */
    public function handle(ProcessedOptions $processed, mixed $next): mixed
    {
        $this->builder = $builder = $processed->builder();

        // Assign target middleware
        $targetList = array_reverse($this->middleware);
        foreach ($targetList as $middleware) {
            $this->assignMiddleware($middleware);
        }

        // Continue...
        return $next($processed);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Assign target middleware, if not already assigned
     *
     * @param class-string<Middleware>|Middleware $middleware Class path or Middleware instance
     */
    protected function assignMiddleware(string|Middleware $middleware)
    {
        // Skip if middleware has already been assigned
        if ($this->isAlreadyAssigned($middleware)) {
            return;
        }

        $this->builder->prependMiddleware($middleware);
    }

    /**
     * Determine if middleware has already been assigned
     *
     * @param class-string<Middleware>|Middleware $middleware Class path or Middleware instance
     *
     * @return bool
     */
    protected function isAlreadyAssigned(string|Middleware $middleware): bool
    {
        $list = $this->builder->getMiddleware();

        foreach ($list as $assignedMiddleware) {
            if ($assignedMiddleware instanceof $middleware) {
                return true;
            }
        }

        return false;
    }
}
