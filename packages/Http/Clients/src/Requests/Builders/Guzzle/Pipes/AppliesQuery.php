<?php


namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes;

use Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException;
use Aedart\Http\Clients\Requests\Builders\ProcessedOptions;

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
     *
     * @throws HttpQueryBuilderException
     */
    public function handle(ProcessedOptions $processed, mixed $next): mixed
    {
        $options = $processed->options();
        $builder = $processed->builder();

        // Extract query from options and append it to the
        // existing query...
        $query = $options['query'] ?? [];

        if (is_string($query)) {
            $builder->raw($query);
        } elseif (is_array($query)) {
            $builder->where($query);
        }

        // Build the query...
        $options['query'] = $builder->query()->build();

        return $next(
            $processed->setOptions($options)
        );
    }
}
