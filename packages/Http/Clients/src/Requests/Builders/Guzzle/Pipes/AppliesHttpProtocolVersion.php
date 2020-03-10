<?php


namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes;

use Aedart\Http\Clients\Requests\Builders\PreparedOptions;

class AppliesHttpProtocolVersion
{
    /**
     * Sets the request's HTTP protocol version
     *
     * @param PreparedOptions $prepared
     * @param mixed $next
     *
     * @return mixed
     */
    public function handle(PreparedOptions $prepared, $next)
    {
        $options = $prepared->options();

        $version = $options['version'] ?? $prepared->builder()->getProtocolVersion();
        $options['version'] = $version;

        return $next(
            $prepared->setOptions($options)
        );
    }
}
