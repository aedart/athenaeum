<?php

namespace Aedart\Http\Clients\Requests\Builders\Pipes;

use Aedart\Http\Clients\Requests\Builders\ProcessedOptions;

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
     * @param ProcessedOptions $processed
     * @param mixed $next
     *
     * @return mixed
     */
    public function handle(ProcessedOptions $processed, $next)
    {
        // Obtain the builder's already set options
        $builderOptions = $processed->builder()->getOptions();

        // Obtain the given options
        $setOptions = $processed->options();

        // Merge them together and overwrite the given options
        $processed->setOptions(
            array_merge($builderOptions, $setOptions)
        );

        return $next($processed);
    }
}
