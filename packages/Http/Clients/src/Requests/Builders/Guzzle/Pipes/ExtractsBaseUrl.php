<?php

namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes;

use Aedart\Http\Clients\Requests\Builders\ProcessedOptions;

/**
 * Extracts Base Url
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes
 */
class ExtractsBaseUrl
{
    /**
     * Extracts 'base_url' from options and applies it onto
     * the builder.
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

        // Extract base url from options
        $baseUrl = $options['base_uri'] ?? '';

        // Set base url on builder and remove it from options
        $builder->withBaseUrl($baseUrl);
        unset($options['base_uri']);

        return $next(
            $processed->setOptions($options)
        );
    }
}
