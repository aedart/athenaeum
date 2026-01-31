<?php

namespace Aedart\Tests\Integration\Http\Clients\Managers;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * HttpClientsManagerTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-manager',
)]
class HttpClientsManagerTest extends HttpClientsTestCase
{
    #[Test]
    public function canObtainInstance()
    {
        $manager = $this->getHttpClientsManager();

        $this->assertNotNull($manager);
    }

    /**
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     */
    #[Test]
    public function canCreateDefaultClient()
    {
        $manager = $this->getHttpClientsManager();
        $client = $manager->profile();

        $this->assertInstanceOf(Client::class, $client);
    }

    /**
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     */
    #[Test]
    public function canObtainDesiredProfile()
    {
        $manager = $this->getHttpClientsManager();
        $client = $manager->profile('json');

        $this->assertInstanceOf(Client::class, $client);
    }

    /**
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     */
    #[Test]
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
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     */
    #[Test]
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
