<?php

namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes;

use Aedart\Http\Clients\Requests\Builders\ProcessedOptions;

/**
 * Applies Base Url
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes
 */
class AppliesBaseUrl
{
    /**
     * Applies 'base_url' onto the driver options, from the
     * builder
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

        // Obtain base url, either from the provided options or builder
        $baseUrl = $options['base_uri'] ?? $builder->getBaseUrl();

        // (Re)apply the base url onto the options
        $options['base_uri'] = $baseUrl;

        return $next(
            $processed->setOptions($options)
        );
    }
}