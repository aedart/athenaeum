<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * X0_GuzzleSpecificTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-x0',
)]
class X0_GuzzleSpecificTest extends HttpClientsTestCase
{
    /**
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function hasHttpErrorsDisabledByDefault()
    {
        $client = $this->client();

        $result = $client->getOption('http_errors');

        $this->assertFalse($result, 'Http errors SHOULD be set to false');
    }

    /**
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function hasConnectTimeoutSetByDefault()
    {
        $client = $this->client();

        $result = $client->getOption('connect_timeout');

        $this->assertGreaterThan(0, $result, 'Connection Timeout SHOULD be set!');
    }

    /**
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function hasRequestTimeoutSetByDefault()
    {
        $client = $this->client();

        $result = $client->getOption('timeout');

        $this->assertGreaterThan(0, $result, 'Timeout SHOULD be set!');
    }

    #[Test]
    public function canSpecifyTimeout()
    {
        $client = $this->client();

        $seconds = (float) $this->getFaker()->randomDigitNotNull();

        $result = $client
            ->withTimeout($seconds)
            ->getTimeout();

        $this->assertSame($seconds, $result, 'Request timeout incorrect');
    }

    /**
     * @throws ProfileNotFoundException
     */
    #[Test]
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
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function canDisableRedirectBehaviour()
    {
        $client = $this->client();

        $builder = $client->maxRedirects(0);

        $result = $builder->getOption('allow_redirects');

        $this->assertFalse($result, 'Allow redirects should be disabled');
    }

    /**
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function canSpecifyMaxRedirects()
    {
        $client = $this->client();

        $builder = $client->maxRedirects(5);

        $result = $builder->getOption('allow_redirects');

        ConsoleDebugger::output($result);

        $this->assertSame(5, $result['max'], 'Max amount of redirects is incorrect');
    }

    #[Test]
    public function canUseFormDataFormat()
    {
        $builder = $this->client()
            ->formFormat();

        $this->assertSame('form_params', $builder->getDataFormat());
    }

    #[Test]
    public function canUseJsonDataFormat()
    {
        $builder = $this->client()
            ->jsonFormat();

        $this->assertSame('json', $builder->getDataFormat());
    }

    #[Test]
    public function canUseMultipartDataFormat()
    {
        $builder = $this->client()
            ->multipartFormat();

        $this->assertSame('multipart', $builder->getDataFormat());
    }
}
