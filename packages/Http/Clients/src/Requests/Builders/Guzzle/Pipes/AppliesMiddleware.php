<?php


namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes;

use Aedart\Http\Clients\Requests\Builders\ProcessedOptions;

/**
 * Applies Middleware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes
 */
class AppliesMiddleware
{
    /**
     * Applies Middleware to the next request and response
     *
     * @param ProcessedOptions $processed
     * @param mixed $next
     *
     * @return mixed
     */
    public function handle(ProcessedOptions $processed, mixed $next): mixed
    {
        $options = $processed->options();
        $builder = $processed->builder();

        // Obtain evt. already assigned middleware via options.
        $existing = $options['middleware'] ?? [];

        // Merge assigned middleware with existing
        $middleware = array_merge($existing, $builder->getMiddleware());

        // Finally, assign middleware to next request and response
        $options['middleware'] = $middleware;

        return $next(
            $processed->setOptions($options)
        );
    }
}
