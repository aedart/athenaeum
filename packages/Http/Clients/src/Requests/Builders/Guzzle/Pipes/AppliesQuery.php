<?php


namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes;

use Aedart\Http\Clients\Requests\Builders\ProcessedOptions;
use function GuzzleHttp\Psr7\parse_query;

/**
 * Applies Query
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes
 */
class AppliesQuery
{
    /**
     * Applies Http query onto the next request's options
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
        if (is_string($query)) {
            $query = parse_query($query);
        }

        // Merge the query from builder, with that from options
        $options['query'] = array_merge($builder->getQuery(), $query);

        return $next(
            $processed->setOptions($options)
        );
    }
}
