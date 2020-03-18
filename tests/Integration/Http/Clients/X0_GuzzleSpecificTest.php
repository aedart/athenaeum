<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;

/**
 * X0_GuzzleSpecificTest
 *
 * @group http-clients
 * @group http-clients-x0
 * @group guzzle
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
class X0_GuzzleSpecificTest extends HttpClientsTestCase
{
    /**
     * @test
     *
     * @throws ProfileNotFoundException
     */
    public function hasHttpErrorsDisabledByDefault()
    {
        $client = $this->client();

        $result = $client->getOption('http_errors');

        $this->assertFalse($result, 'Http errors SHOULD be set to false');
    }

    /**
     * @test
     *
     * @throws ProfileNotFoundException
     */
    public function hasConnectTimeoutSetByDefault()
    {
        $client = $this->client();

        $result = $client->getOption('connect_timeout');

        $this->assertGreaterThan(0, $result, 'Connection Timeout SHOULD be set!');
    }

    /**
     * @test
     *
     * @throws ProfileNotFoundException
     */
    public function hasRequestTimeoutSetByDefault()
    {
        $client = $this->client();

        $result = $client->getOption('timeout');

        $this->assertGreaterThan(0, $result, 'Timeout SHOULD be set!');
    }

    /**
     * @test
     */
    public function canSpecifyTimeout()
    {
        $client = $this->client();

        $seconds = (float) $this->getFaker()->randomDigitNotNull;

        $result = $client
            ->withTimeout($seconds)
            ->getTimeout();

        $this->assertSame($seconds, $result, 'Request timeout incorrect');
    }

    /**
     * @test
     *
     * @throws ProfileNotFoundException
     */
    public function hasFollowRedirectsSetByDefault()
    {
        $client = $this->client();

        $result = $client->getOption('allow_redirects');

        ConsoleDebugger::output($result);

        $this->assertSame(1, $result['max'], 'Max amount of redirects is incorrect');
        $this->assertSame(true, $result['strict'], 'Should be strict redirects');
        $this->assertSame(true, $result['referer'], 'Should have referer set to true');
        $this->assertSame(['http', 'https'], $result['protocols'], 'Incorrect protocols');
        $this->assertSame(false, $result['track_redirects'], 'Should not track redirects');
    }

    /**
     * @test
     *
     * @throws ProfileNotFoundException
     */
    public function canDisableRedirectBehaviour()
    {
        $client = $this->client();

        $builder = $client->maxRedirects(0);

        $result = $builder->getOption('allow_redirects');

        $this->assertFalse($result, 'Allow redirects should be disabled');
    }

    /**
     * @test
     *
     * @throws ProfileNotFoundException
     */
    public function canSpecifyMaxRedirects()
    {
        $client = $this->client();

        $builder = $client->maxRedirects(5);

        $result = $builder->getOption('allow_redirects');

        ConsoleDebugger::output($result);

        $this->assertSame(5, $result['max'], 'Max amount of redirects is incorrect');
    }

    /**
     * @test
     */
    public function canUseFormDataFormat()
    {
        $builder = $this->client()
            ->formFormat();

        $this->assertSame('form_params', $builder->getDataFormat());
    }

    /**
     * @test
     */
    public function canUseJsonDataFormat()
    {
        $builder = $this->client()
            ->jsonFormat();

        $this->assertSame('json', $builder->getDataFormat());
    }

    /**
     * @test
     */
    public function canUseMultipartDataFormat()
    {
        $builder = $this->client()
            ->multipartFormat();

        $this->assertSame('multipart', $builder->getDataFormat());
    }
}
