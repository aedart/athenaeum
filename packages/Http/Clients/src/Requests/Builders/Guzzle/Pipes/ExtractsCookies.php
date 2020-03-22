<?php

namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes;

use Aedart\Http\Clients\Requests\Builders\Guzzle\CookiesHelper;
use Aedart\Http\Clients\Requests\Builders\ProcessedOptions;
use Throwable;

/**
 * Extracts Cookies
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes
 */
class ExtractsCookies
{
    /**
     * Extracts cookies from Guzzle's options (Cookie Jar),
     * and applies them onto the builder
     *
     * @param ProcessedOptions $processed
     * @param mixed $next
     *
     * @return mixed
     *
     * @throws Throwable
     */
    public function handle(ProcessedOptions $processed, $next)
    {
        $options = $processed->options();
        $builder = $processed->builder();

        // Extract the cookies from the driver options.
        $cookies = CookiesHelper::extract($options, $builder);

        // Remove the "cookies" option, to avoid issues later...
        unset($options['cookies']);

        // Add the cookies into the builder (if any available)
        $builder->withCookies($cookies);

        // Finally, set options and return next pipe
        return $next(
            $processed->setOptions($options)
        );
    }
}