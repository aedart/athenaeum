<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Clients\Requests\Builders\Guzzle\CookieJarAware;
use Aedart\Contracts\Http\Cookies\Cookie;
use Aedart\Contracts\Http\Cookies\SameSite;
use Aedart\Contracts\Http\Cookies\SetCookie;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use DateTime;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Teapot\StatusCode;

/**
 * H0_CookiesTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-h0',
)]
class H0_CookiesTest extends HttpClientsTestCase
{
    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function extractsCookiesFromOptions(string $profile)
    {
        $cookieJar = $this->makeCookieJar([
            'first_cookie' => 'foo',
            'second_cookie' => 'bar'
        ]);

        $client = $this->client($profile, [ 'cookies' => $cookieJar ]);

        $this->assertTrue($client->hasCookie('first_cookie'), 'First cookie not extracted from options');
        $this->assertSame('foo', $client->getCookie('first_cookie')->getValue(), 'Incorrect cookie value');

        $this->assertTrue($client->hasCookie('second_cookie'), 'Second cookie not extracted from options');
        $this->assertSame('bar', $client->getCookie('second_cookie')->getValue(), 'Incorrect cookie value');
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function canAddCookieUsingInstance(string $profile)
    {
        $domain = 'https://acme.com';
        $cookie = $this->makeCookie()
            ->name('foo')
            ->domain($domain)
            ->value('bar');

        $mock = $this->makeResponseMock([
            new Response(StatusCode::OK, ['Set-Cookie' => 'foo=bar']),
            new Response()
        ]);

        $builder = $this->client($profile, [ 'cookies' => true ])
            ->withOption('handler', $mock)
            ->withCookie($cookie);

        $builder->post($domain . '/records');
        $builder->post($domain . '/records');

        // --------------------------------------------------------------- //

        $this->assertTrue($builder->hasCookie('foo'), 'Cookie not in builder');

        // --------------------------------------------------------------- //

        $request = $this->lastRequest;
        $cookieHeader = $request->getHeaderLine('Cookie');
        ConsoleDebugger::output($cookieHeader);

        $this->assertStringContainsString('foo=bar', $cookieHeader, 'Cookie header not set correctly');
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function canAddCookieUsingArray(string $profile)
    {
        $domain = 'https://acme.com';
        $cookie = [
            'name' => 'foo',
            'domain' => $domain,
            'value' => 'bar'
        ];

        $mock = $this->makeResponseMock([
            new Response(StatusCode::OK, ['Set-Cookie' => 'foo=bar']),
            new Response()
        ]);

        $builder = $this->client($profile)
            ->withOption('handler', $mock)
            ->withCookie($cookie);

        $builder->post($domain . '/records');
        $builder->post($domain . '/records');

        // --------------------------------------------------------------- //

        $this->assertTrue($builder->hasCookie('foo'), 'Cookie not in builder');

        // --------------------------------------------------------------- //

        $request = $this->lastRequest;
        $cookieHeader = $request->getHeaderLine('Cookie');
        ConsoleDebugger::output($cookieHeader);

        $this->assertStringContainsString('foo=bar', $cookieHeader, 'Cookie header not set correctly');
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function canAddCookieUsingCallback(string $profile)
    {
        $domain = 'https://acme.com';
        $cookie = function (Cookie|SetCookie $cookie) use ($domain) {
            $cookie
                ->name('foo')
                ->domain($domain)
                ->value('bar');
        };

        $mock = $this->makeResponseMock([
            new Response(StatusCode::OK, ['Set-Cookie' => 'foo=bar']),
            new Response()
        ]);

        $builder = $this->client($profile)
            ->withOption('handler', $mock)
            ->withCookie($cookie);

        $builder->post($domain . '/records');
        $builder->post($domain . '/records');

        // --------------------------------------------------------------- //

        $this->assertTrue($builder->hasCookie('foo'), 'Cookie not in builder');

        // --------------------------------------------------------------- //

        $request = $this->lastRequest;
        $cookieHeader = $request->getHeaderLine('Cookie');
        ConsoleDebugger::output($cookieHeader);

        $this->assertStringContainsString('foo=bar', $cookieHeader, 'Cookie header not set correctly');
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function canAddCookieUsingOptions(string $profile)
    {
        $domain = 'https://acme.com';
        $cookieJar = $this->makeCookieJar([
            'foo' => 'bar'
        ], $domain);

        $mock = $this->makeResponseMock([
            new Response(StatusCode::OK, ['Set-Cookie' => 'foo=bar']),
            new Response()
        ]);

        $builder = $this->client($profile)
            ->withOption('handler', $mock);

        $builder->request('get', $domain . '/records', [ 'cookies' => $cookieJar ]);
        $builder->request('get', $domain . '/records');

        // --------------------------------------------------------------- //

        $this->assertFalse($builder->hasCookie('foo'), 'Cookie should NOT be added to builder');

        // --------------------------------------------------------------- //

        $request = $this->lastRequest;
        $cookieHeader = $request->getHeaderLine('Cookie');
        ConsoleDebugger::output($cookieHeader);

        $this->assertStringContainsString('foo=bar', $cookieHeader, 'Cookie header not set correctly');
    }

    /**
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function preservesCookieJar()
    {
        // Create mocked response, with Set-Cookie header

        $name = 'foo';
        $value = 'bar';
        $domain = 'acme.org';
        $path = '/somwehere';
        $expiresAt = Carbon::now()->addRealDays(3);
        $expires = gmdate(DateTime::RFC7231, $expiresAt->getTimestamp());
        $maxAge = $this->getFaker()->randomNumber(3, true);
        $secure = true;
        $httpOnly = true;
        $sameSite = SameSite::STRICT;
        $header = "{$name}={$value}; Domain={$domain}; Path={$path}; Expires={$expires}; Max-Age={$maxAge}; Secure; HttpOnly; SameSite={$sameSite->value};";

        $mockedResponse = new Response(StatusCode::OK, [
            'Set-Cookie' => $header
        ]);

        // --------------------------------------------------------------- //

        // Create Cookie Jar
        $cookieJar = $this->makeCookieJar([], $domain);

        // Apply mocked response and cookie jar
        /** @var Builder|CookieJarAware $builder */
        $builder = $this->client('default')
            ->withOption('handler', $this->makeResponseMock([ $mockedResponse ]))
            ->setCookieJar($cookieJar);

        // Perform a request
        $response = $builder->get("https://$domain/records");

        // --------------------------------------------------------------- //

        ConsoleDebugger::output($response);
        $this->assertSame($cookieJar, $builder->getCookieJar());

        // --------------------------------------------------------------- //

        $this->assertCount(1, $cookieJar);

        // Obtain single cookie form jar... seems a bit frustrating to do it
        // this way, but interface offers no other method.
        /** @var \GuzzleHttp\Cookie\SetCookie $cookie */
        $cookie = null;
        foreach ($cookieJar as $storedCookie) {
            $cookie = $storedCookie;
        }

        $this->assertNotNull($cookie, 'Unable to obtain cookie from CookieJar');

        // --------------------------------------------------------------- //

        $this->assertSame($name, $cookie->getName(), 'Incorrect name');
        $this->assertSame($value, $cookie->getValue(), 'Incorrect value');
        $this->assertSame($domain, $cookie->getDomain(), 'Incorrect domain');
        $this->assertSame($path, $cookie->getPath(), 'Incorrect path');

        $expiresAtFromCookie = Carbon::createFromTimestamp($cookie->getExpires());
        $this->assertTrue($expiresAt->equalTo($expiresAtFromCookie), 'Incorrect expires at');

        $this->assertSame($maxAge, (int) $cookie->getMaxAge(), 'Incorrect max-age');
        $this->assertSame($secure, $cookie->getSecure(), 'Incorrect secure');
        $this->assertSame($httpOnly, $cookie->getHttpOnly(), 'Incorrect http-only');

        $data = $cookie->toArray();
        $this->assertArrayHasKey('SameSite', $data, 'Same Site does not exist');
        $this->assertSame($data['SameSite'], $sameSite?->value, 'Incorrect Same Site');
    }
}
