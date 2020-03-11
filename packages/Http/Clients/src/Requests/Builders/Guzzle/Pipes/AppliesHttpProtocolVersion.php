<?php


namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes;

use Aedart\Http\Clients\Requests\Builders\ProcessedOptions;

/**
 * Applies Http Protocol Version
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes
 */
class AppliesHttpProtocolVersion
{
    /**
     * Sets the request's HTTP protocol version
     *
     * @param ProcessedOptions $processed
     * @param mixed $next
     *
     * @return mixed
     */
    public function handle(ProcessedOptions $processed, $next)
    {
        $options = $processed->options();

        $version = $options['version'] ?? $processed->builder()->getProtocolVersion();
        $options['version'] = $version;

        return $next(
            $processed->setOptions($options)
        );
    }
}
