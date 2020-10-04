<?php

namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes;

use Aedart\Http\Clients\Requests\Builders\ProcessedOptions;

/**
 * Extracts Middleware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes
 */
class ExtractsMiddleware
{
    /**
     * Extracts middleware from options and assigns it to
     * the request builder
     *
     * @param ProcessedOptions $processed
     * @param mixed $next
     *
     * @return mixed
     */
    public function handle(ProcessedOptions $processed, $next)
    {
        $options = $processed->options();
        $builder = $processed->builder();

        $middleware = $options['middleware'] ?? [];

        if (!empty($middleware)) {
            $builder->withMiddleware($middleware);
        }

        unset($options['middleware']);

        return $next(
            $processed->setOptions($options)
        );
    }
}
