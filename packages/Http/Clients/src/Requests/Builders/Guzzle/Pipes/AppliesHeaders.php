<?php

namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes;

use Aedart\Http\Clients\Requests\Builders\PreparedOptions;

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
     * @param PreparedOptions $prepared
     * @param mixed $next
     *
     * @return mixed
     */
    public function handle(PreparedOptions $prepared, $next)
    {
        $options = $prepared->options();

        $headersFromOptions = $options['headers'] ?? [];
        $headersFromBuilder = $prepared->builder()->getHeaders();

        $options['headers'] = array_merge($headersFromBuilder, $headersFromOptions);

        return $next(
            $prepared->setOptions($options)
        );
    }
}
