<?php

namespace Aedart\Http\Clients\Requests\Builders\Guzzle;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Clients\Requests\Builders\Guzzle\CookieJarAware;
use Aedart\Contracts\Http\Cookies\Cookie;
use Aedart\Contracts\Http\Cookies\SetCookie;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\CookieJarInterface;
use GuzzleHttp\Cookie\SetCookie as GuzzleCookie;
use InvalidArgumentException;
use Throwable;

/**
 * Guzzle Cookies Helper
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Guzzle
 */
class CookiesHelper
{
    /**
     * The request builder
     *
     * @var Builder
     */
    protected Builder $builder;

    /**
     * CookiesHelper constructor.
     *
     * @param Builder $builder
     */
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Extracts Cookies from the driver options and converts them
     * into Cookie-objects that the request builder accepts
     *
     * @see extractFromDriverOptions
     *
     * @param array $options
     * @param Builder $builder
     *
     * @return Cookie[]
     *
     * @throws InvalidArgumentException
     * @throws Throwable
     */
    public static function extract(array $options, Builder $builder): array
    {
        return (new static($builder))->extractFromDriverOptions($options);
    }

    /**
     * Convert the cookies available from the given Guzzle
     * Cookie Jar, into a list of {@see Cookie}s
     *
     * @see convertFromCookieJar
     *
     * @param CookieJarInterface $cookieJar
     * @param Builder $builder
     *
     * @return Cookie[]
     *
     * @throws Throwable
     */
    public static function fromCookieJar(CookieJarInterface $cookieJar, Builder $builder): array
    {
        return (new static($builder))->convertFromCookieJar($cookieJar);
    }

    /**
     * Extracts Cookies from the driver options and converts them
     * into Cookie-objects that the request builder accepts
     *
     * @param array $options [optional]
     *
     * @return Cookie[]
     *
     * @throws InvalidArgumentException
     * @throws Throwable
     */
    public function extractFromDriverOptions(array $options = []): array
    {
        // Resolve Cookie Jar instance from the options. Abort if it
        // does not contain any cookies.
        $cookieJar = $this->resolveCookieJar($options);
        if ($cookieJar->count() === 0){
            return [];
        }

        // Convert each cookie stored in the Cookie Jar into a Cookie
        // object that the request builder accepts.
        return $this->convertFromCookieJar($cookieJar);
    }

    /**
     * Convert the cookies available from the given Guzzle
     * Cookie Jar, into a list of {@see Cookie}s
     *
     * @param CookieJarInterface $jar
     *
     * @return Cookie[]
     *
     * @throws Throwable
     */
    public function convertFromCookieJar(CookieJarInterface $jar): array
    {
        $cookies = [];
        foreach ($jar as $cookie){
            $cookies[] = $this->convertFromGuzzle($cookie);
        }

        return $cookies;
    }

    /**
     * Convert the {@see GuzzleCookie} into a {@see Cookie}
     *
     * @param GuzzleCookie $cookie
     *
     * @return Cookie
     *
     * @throws Throwable
     */
    public function convertFromGuzzle(GuzzleCookie $cookie): Cookie
    {
        $builderCookie = $this->builder()->makeCookie();

        // Populate the name and value
        $builderCookie->populate([
            'name' => $cookie->getName(),
            'value' => $cookie->getValue()
        ]);

        // In case that a "Set-Cookie" instance is given, we
        // attempt to populate it. This is SHOULD only be
        // required when working with cookies from responses.
        if ($builderCookie instanceof SetCookie){
            $secure = $cookie->getSecure() ?? false;

            $builderCookie->populate([
                'expires' => $cookie->getExpires(),
                'maxAge' => $cookie->getMaxAge(),
                'domain' => $cookie->getDomain(),
                'path' => $cookie->getPath(),
                'secure' => $secure,
                'httpOnly' => $cookie->getHttpOnly(),

                // Same site policy does not appear to be supported
                // by Guzzle. Therefore, we default it to null.
                //'sameSite' => SetCookie::SAME_SITE_LAX
            ]);
        }

        return $builderCookie;
    }

    /**
     * Returns the request builder used by this helper
     *
     * @return Builder
     */
    public function builder(): Builder
    {
        return $this->builder;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Resolves a Cookie Jar instance from given options.
     *
     * If the options do not contain a valid Cookie Jar instance, the
     * method will either obtain it from the builder or create a default
     * instance.
     *
     * @see http://docs.guzzlephp.org/en/stable/quickstart.html#cookies
     * @see http://docs.guzzlephp.org/en/stable/request-options.html#cookies
     *
     * @param array $options [optional]
     *
     * @return CookieJarInterface
     *
     * @throws InvalidArgumentException
     */
    protected function resolveCookieJar(array $options = []): CookieJarInterface
    {
        // According to Guzzle's documentation, the "cookies" options is either
        // a boolean value or instance of "Cookie Jar". Therefore, we must
        // resolve the cookie jar by checking for those values.
        $cookieJar = $options['cookies'] ?? false;

        // If a cookie jar instance has been provided in the options, then
        // we simple return it.
        if($cookieJar instanceof CookieJarInterface){
            return $cookieJar;
        }

        // Otherwise, we expect a boolean value. If this isn't the case, then
        // an invalid value has been provided and we abort.
        if(!is_bool($cookieJar)){
            throw new InvalidArgumentException('"cookies" option MUST be a boolean value or instance of Guzzle\'s CookieJarInterface');
        }

        // Regardless if the value is "true" or "false", we obtain a cookie jar
        // instance, either from the builder or by creating a default.
        return $this->obtainCookieJar($this->builder());
    }

    /**
     * Obtains a cookie jar from the builder or creates a default
     * instance.
     *
     * @see makeDefaultCookieJar
     *
     * @param Builder $builder
     *
     * @return CookieJarInterface
     */
    protected function obtainCookieJar(Builder $builder): CookieJarInterface
    {
        if($builder instanceof CookieJarAware){
            return $builder->getCookieJar();
        }

        return $this->makeDefaultCookieJar();
    }

    /**
     * Creates a default Cookie Jar instance
     *
     * @return CookieJarInterface
     */
    protected function makeDefaultCookieJar(): CookieJarInterface
    {
        return new CookieJar();
    }
}