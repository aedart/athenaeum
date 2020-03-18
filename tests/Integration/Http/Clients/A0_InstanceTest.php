<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;

/**
 * A0_InstanceTest
 *
 * @group http-clients
 * @group http-clients-a0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
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
    public function canCreateBuilder(string $profile)
    {
        $client = $this->client($profile);
        $builder = $client->makeBuilder();

        $this->assertNotNull($builder);
    }
}