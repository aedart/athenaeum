<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\ResponseInterface;

/**
 * D1_HttpProtocolVersionTest
 *
 * @group http-clients
 * @group http-clients-d1
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-d1',
)]
class D1_HttpProtocolVersionTest extends HttpClientsTestCase
{
    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function extractsHttpProtocolVersionFromOptions(string $profile)
    {
        $version = '2.0';

        $client = $this->client($profile, [
            'version' => $version
        ]);

        $this->assertSame($version, $client->getProtocolVersion(), 'Did not extract Http protocol version from options');
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function usesHttpProtocolVersion(string $profile)
    {
        $client = $this->client($profile);

        $version = '2.0';

        /** @var ResponseInterface $response */
        $client
            ->withOption('handler', $this->makeRespondsOkMock())
            ->useProtocolVersion($version)
            ->request('get', '/users');

        $versionFromRequest = $this->lastRequest->getProtocolVersion();
        $this->assertSame($version, $versionFromRequest, 'Custom Http protocol version not set on request');
    }
}
