<?php

namespace Aedart\Http\Clients\Requests\Builders\Guzzle;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Clients\Requests\Builders\Guzzle\CookieJarAware;
use Aedart\Contracts\Http\Cookies\Cookie;
use Aedart\Contracts\Http\Cookies\SetCookie;
use DateTime;
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
     * Creates a new helpers instance
     *
     * @param Builder $builder
     *
     * @return static
     */
    public static function make(Builder $builder): static
    {
        return new static($builder);
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
        return static::make($builder)->extractFromDriverOptions($options);
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
        return static::make($builder)->convertFromCookieJar($cookieJar);
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
        if ($cookieJar->count() === 0) {
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
        foreach ($jar as $cookie) {
            $cookies[] = $this->convertFromGuzzle($cookie);
        }

        return $cookies;
    }

    /**
     * Converts all {@see Cookie}s into {@see GuzzleCookie} and populates
     * a {@see CookieJarInterface}.
     *
     * Method resolves the {@see CookieJarInterface} from given driver options
     * or from the builder via the {@see resolveCookieJar} method
     *
     * @see resolveCookieJar
     *
     * @param array $options [optional]
     *
     * @return CookieJarInterface
     */
    public function convertFromBuilder(array $options = []): CookieJarInterface
    {
        return $this->populateJar(
            $this->resolveCookieJar($options),
            $this->builder()->getCookies()
        );
    }

    /**
     * Populates Cookie Jar with given list of {@see Cookie}
     *
     * @param CookieJarInterface $cookieJar
     * @param Cookie[] $cookies [optional]
     *
     * @return CookieJarInterface Populated Cookie Jar
     */
    public function populateJar(CookieJarInterface $cookieJar, array $cookies = []): CookieJarInterface
    {
        foreach ($cookies as $cookie) {
            $cookieJar->setCookie($this->convertToGuzzle($cookie));
        }

        return $cookieJar;
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
        // attempt to populate it. This SHOULD only be
        // required when working with cookies from responses.
        if ($builderCookie instanceof SetCookie) {
            $secure = $cookie->getSecure() ?? false;

            // SameSite directive might be included into Guzzle's
            // Set-Cookie instance. But it can only be obtained via
            // the toArray() method.
            // @see https://github.com/aedart/athenaeum/issues/8
            $data = $cookie->toArray();
            $sameSite = $data['SameSite'] ?? null;

            $builderCookie->populate([
                'expires' => $cookie->getExpires(),
                'maxAge' => $cookie->getMaxAge(),
                'domain' => $cookie->getDomain(),
                'path' => $cookie->getPath(),
                'secure' => $secure,
                'httpOnly' => $cookie->getHttpOnly(),
                'sameSite' => $sameSite
            ]);
        }

        return $builderCookie;
    }

    /**
     * Converts given {@see Cookie} into a {@see GuzzleCookie}
     *
     * @param Cookie $cookie
     *
     * @return GuzzleCookie
     */
    public function convertToGuzzle(Cookie $cookie): GuzzleCookie
    {
        // Same site might be obtainable from Guzzle's Set-Cookie,
        // but can only be when creating a new instance, directly
        // via the data array. I do miss a "setSameSite" method,
        // but this will have to do for now...
        // @see https://github.com/aedart/athenaeum/issues/8
        $data = [];
        if ($cookie instanceof SetCookie && !is_null($cookie->getSameSite())) {
            $data['SameSite'] = $cookie->getSameSite();
        }

        // Create Guzzle Set-Cookie
        $guzzleCookie = $this->makeGuzzleCookie($data);

        // Set name and value
        $guzzleCookie->setName($cookie->getName());
        $guzzleCookie->setValue($cookie->getValue());

        // In case that the Cookie is a "Set-Cookie", populate
        // remaining directives.
        if ($cookie instanceof SetCookie) {
            $guzzleCookie = $this->applyExpiresOnGuzzleCookie($guzzleCookie, $cookie->getExpires());
            $guzzleCookie->setMaxAge($cookie->getMaxAge());

            $domain = $cookie->getDomain() ?? $guzzleCookie->getDomain();
            $guzzleCookie->setDomain($domain);

            $guzzleCookie->setPath($cookie->getPath());
            $guzzleCookie->setSecure($cookie->isSecure());
            $guzzleCookie->setHttpOnly($cookie->isHttpOnly());
        }

        return $guzzleCookie;
    }



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
    public function resolveCookieJar(array $options = []): CookieJarInterface
    {
        // According to Guzzle's documentation, the "cookies" options is either
        // a boolean value or instance of "Cookie Jar". Therefore, we must
        // resolve the cookie jar by checking for those values.
        $cookieJar = $options['cookies'] ?? false;

        // If a cookie jar instance has been provided in the options, then
        // we simple return it.
        if ($cookieJar instanceof CookieJarInterface) {
            return $cookieJar;
        }

        // Otherwise, we expect a boolean value. If this isn't the case, then
        // an invalid value has been provided and we abort.
        if (!is_bool($cookieJar)) {
            throw new InvalidArgumentException('"cookies" option MUST be a boolean value or instance of Guzzle\'s CookieJarInterface');
        }

        // Regardless if the value is "true" or "false", we obtain a cookie jar
        // instance, either from the builder or by creating a default.
        return $this->obtainCookieJar($this->builder());
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
        if ($builder instanceof CookieJarAware) {
            return $builder->getCookieJar();
        }

        return $this->makeDefaultCookieJar();
    }

    /**
     * Sets the expires directory on given {@see GuzzleCookie}, if a valid
     * expires at date is provided.
     *
     * @param GuzzleCookie $guzzleCookie
     * @param string|null $expiresAt [optional]
     *
     * @return GuzzleCookie
     */
    protected function applyExpiresOnGuzzleCookie(GuzzleCookie $guzzleCookie, $expiresAt = null): GuzzleCookie
    {
        if (!isset($expiresAt)) {
            return $guzzleCookie;
        }

        $guzzleCookie->setExpires(
            $this->rfcDateToTimestamp($expiresAt)
        );

        return $guzzleCookie;
    }

    /**
     * Converts a RFC7231 formatted string date into a timestamp
     *
     * @param string|null $date [optional]
     *
     * @return int|null Null if no date is given
     */
    protected function rfcDateToTimestamp(string|null $date = null): int|null
    {
        if (!isset($date)) {
            return null;
        }

        return DateTime::createFromFormat(DateTime::RFC7231, $date)->getTimestamp();
    }

    /**
     * Creates a new Guzzle Set-Cookie instance
     *
     * @param array $data [optional]
     *
     * @return GuzzleCookie
     */
    protected function makeGuzzleCookie(array $data = []): GuzzleCookie
    {
        return new GuzzleCookie($data);
    }

    /**
     * Creates a default Cookie Jar instance
     *
     * @return CookieJarInterface
     */
    protected function makeDefaultCookieJar(): CookieJarInterface
    {
        return new CookieJar(true);
    }
}
