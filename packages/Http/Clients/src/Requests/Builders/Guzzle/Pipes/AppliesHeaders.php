<?php

namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes;

use Aedart\Http\Clients\Requests\Builders\ProcessedOptions;

/**
 * Applies Headers
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes
 */
class AppliesHeaders
{
    /**
     * Sets the request's headers, via the options
     *
     * @param ProcessedOptions $processed
     * @param mixed $next
     *
     * @return mixed
     */
    public function handle(ProcessedOptions $processed, $next)
    {
        $options = $processed->options();

        $headersFromOptions = $options['headers'] ?? [];
        $headersFromBuilder = $processed->builder()->getHeaders();

        $options['headers'] = array_merge($headersFromBuilder, $headersFromOptions);

        return $next(
            $processed->setOptions($options)
        );
    }
}
