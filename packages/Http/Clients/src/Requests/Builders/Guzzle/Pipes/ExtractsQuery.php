<?php

namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes;

use Aedart\Http\Clients\Requests\Builders\ProcessedOptions;

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
    public function handle(ProcessedOptions $processed, mixed $next): mixed
    {
        $options = $processed->options();
        $builder = $processed->builder();

        // Ensure that the Http Query Grammar is set in the builder,
        // as an option, before attempting to proceed.
        $grammar = $options['grammar-profile'] ?? 'default';
        $builder->withOption('grammar-profile', $grammar);

        // Extract query from options and append it to the
        // http query builder instance
        $query = $options['query'] ?? [];

        if (is_string($query)) {
            $builder->raw($query);
        } elseif (is_array($query)) {
            $builder->where($query);
        }

        unset($options['query']);

        return $next(
            $processed->setOptions($options)
        );
    }
}
