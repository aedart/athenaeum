<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;

/**
 * C3_BaseUrlTest
 *
 * @group http-clients
 * @group http-clients-c3
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
class C3_BaseUrlTest extends HttpClientsTestCase
{
    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function extractsBaseUrlFromOptions(string $profile)
    {
        $url = 'https://acme.org';

        $client = $this->client($profile, [
            'base_uri' => $url
        ]);

        $this->assertTrue($client->hasBaseUrl(), 'No base url extracted');
        $this->assertSame($url, $client->getBaseUrl(), 'Incorrect base url extracted');
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function canSetBaseUrl(string $profile)
    {
        $baseUrl = 'https://acme.org';

        $this
            ->client($profile)
            ->withOption('handler', $this->makeRespondsOkMock())
            ->withBaseUrl($baseUrl)
            ->get('/users');

        $url = $this->lastRequest->getUri();
        ConsoleDebugger::output((string) $url);

        $this->assertStringContainsString($baseUrl, $url);
    }
}
