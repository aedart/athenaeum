<?php

namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes;

use Aedart\Http\Clients\Requests\Builders\ProcessedOptions;

use function GuzzleHttp\Psr7\parse_query;

/**
 * Extracts Http query string values
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes
 */
class ExtractsQuery
{
    /**
     * Extracts Http query string values from options
     * and applies them onto the builder
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

        // Extract query from options
        $query = $options['query'] ?? [];

        // Guzzle also accepts a string as option value.
        // Therefore, we parse it using Guzzle's own method
        if(is_string($query)){
            $query = parse_query($query);
        }

        // Set query onto builder and unset it from the options
        $builder->setQuery($query);
        unset($options['query']);

        return $next(
            $processed->setOptions($options)
        );
    }
}