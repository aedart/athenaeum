<?php

namespace Aedart\Tests\Integration\Http\Clients\Managers;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;

/**
 * HttpClientsManagerTest
 *
 * @group http
 * @group http-clients
 * @group http-clients-manager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
class HttpClientsManagerTest extends HttpClientsTestCase
{
    /**
     * @test
     */
    public function canObtainInstance()
    {
        $manager = $this->getHttpClientsManager();

        $this->assertNotNull($manager);
    }

    /**
     * @test
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     */
    public function canCreateDefaultClient()
    {
        $manager = $this->getHttpClientsManager();
        $client = $manager->profile();

        $this->assertInstanceOf(Client::class, $client);
    }

    /**
     * @test
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     */
    public function canObtainDesiredProfile()
    {
        $manager = $this->getHttpClientsManager();
        $client = $manager->profile('json');

        $this->assertInstanceOf(Client::class, $client);
    }

    /**
     * @test
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     */
    public function returnsSameClient()
    {
        $manager = $this->getHttpClientsManager();

        // Same "default" profile requested
        $clientA = $manager->profile();
        $clientB = $manager->profile();

        // Expecting exact same http client to be returned
        $this->assertTrue($clientA === $clientB);
    }

    /**
     * @test
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     */
    public function returnFreshInstance()
    {
        $manager = $this->getHttpClientsManager();

        // "fresh" instance should not be the same as the one that was cached!
        $clientA = $manager->profile();
        $clientB = $manager->fresh();

        // Expecting different instances
        $this->assertFalse($clientA === $clientB);
    }
}
