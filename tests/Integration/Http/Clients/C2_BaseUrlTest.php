<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * C3_BaseUrlTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-c2',
)]
class C2_BaseUrlTest extends HttpClientsTestCase
{
    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
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
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
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
