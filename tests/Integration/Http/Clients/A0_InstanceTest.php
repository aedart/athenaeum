<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * A0_InstanceTest
 *
 * @group http-clients
 * @group http-clients-a0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-a0',
)]
class A0_InstanceTest extends HttpClientsTestCase
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
    public function canObtainInstance(string $profile)
    {
        $client = $this->client($profile);

        $this->assertNotNull($client);
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
    public function canObtainDriver(string $profile)
    {
        $client = $this->client($profile);
        $driver = $client->driver();

        $this->assertNotNull($driver);
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
    public function canCreateBuilder(string $profile)
    {
        $client = $this->client($profile);
        $builder = $client->makeBuilder();

        $this->assertNotNull($builder);
    }
}
