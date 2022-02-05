<?php


namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes;

use Aedart\Contracts\Http\Clients\Requests\Builders\Guzzle\CookieJarAware;
use Aedart\Http\Clients\Requests\Builders\Guzzle\CookiesHelper;
use Aedart\Http\Clients\Requests\Builders\ProcessedOptions;
use Throwable;

/**
 * Applies Cookies
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes
 */
class AppliesCookies
{
    /**
     * Applies cookies from the builder onto the driver specific options
     *
     * @param ProcessedOptions $processed
     * @param mixed $next
     *
     * @return mixed
     *
     * @throws Throwable
     */
    public function handle(ProcessedOptions $processed, mixed $next): mixed
    {
        $options = $processed->options();
        $builder = $processed->builder();
        $helper = CookiesHelper::make($builder);
        $cookieJar = $helper->resolveCookieJar($options);

        // Extract the cookies from the driver options, in case these
        // have been given via the request() or withOptions() methods.
        $cookiesFromOptions = $helper->extractFromDriverOptions($options);

        // Obtain the cookies from the builder and merge these with those
        // from the driver options. We abort and go to next pipe, if there
        // are no cookies available.
        $cookies = array_merge($builder->getCookies(), $cookiesFromOptions);
        if (empty($cookies)) {
            return $next($processed);
        }

        // Set the "cookies" driver option
        $cookieJar = $helper->populateJar($cookieJar, $cookies);
        $options['cookies'] = $cookieJar;

        // Ensure that the Cookie Jar remains in memory (in case a new one was created)
        // by setting it onto the builder - provided that it has support for such.
        // In theory, the resolved Cookie Jar could be the same as the one already set,
        // but we have no way of knowing this for sure.
        if ($builder instanceof CookieJarAware) {
            $builder->setCookieJar($cookieJar);
        }

        // Finally, set options and return next pipe
        return $next(
            $processed->setOptions($options)
        );
    }
}
