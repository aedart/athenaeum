<?php

namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes;

use Aedart\Http\Clients\Requests\Builders\ProcessedOptions;

/**
 * Extract Http Protocol Version
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes
 */
class ExtractHttpProtocolVersion
{
    /**
     * Extracts the HTTP protocol version from options
     * and applies it on the builder
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

        $version = $options['version'] ?? $builder->getProtocolVersion();
        $builder->useProtocolVersion($version);

        unset($options['version']);

        return $next(
            $processed->setOptions($options)
        );
    }
}
