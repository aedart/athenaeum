<?php

namespace Aedart\Http\Clients\Requests\Builders\Pipes;

use Aedart\Http\Clients\Requests\Builders\PreparedOptions;

/**
 * Merge With Builder Options
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Pipes
 */
class MergeWithBuilderOptions
{
    /**
     * Merges given options with builder's already set options
     *
     * @param PreparedOptions $prepared
     * @param mixed $next
     *
     * @return mixed
     */
    public function handle(PreparedOptions $prepared, $next)
    {
        // Obtain the builder's already set options
        $builderOptions = $prepared->builder()->getOptions();

        // Obtain the given options
        $setOptions = $prepared->preparedOptions();

        // Merge them together and overwrite the given options
        $prepared->setPreparedOptions(
            array_merge($builderOptions, $setOptions)
        );

        return $next($prepared);
    }
}
