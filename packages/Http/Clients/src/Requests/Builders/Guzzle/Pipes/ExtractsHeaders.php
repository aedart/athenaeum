<?php


namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes;

use Aedart\Http\Clients\Requests\Builders\ProcessedOptions;

/**
 * Extracts Headers
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes
 */
class ExtractsHeaders
{
    /**
     * Extracts headers from Guzzle options and applies
     * them on the builder.
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

        $headers = $options['headers'] ?? [];

        if (!empty($headers)) {
            $builder->withHeaders($headers);
        }

        unset($options['headers']);

        return $next(
            $processed->setOptions($options)
        );
    }
}
