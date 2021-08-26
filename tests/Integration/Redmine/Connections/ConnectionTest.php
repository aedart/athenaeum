<?php

namespace Aedart\Tests\Integration\Redmine\Connections;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Redmine\Exceptions\ConnectionException;
use Aedart\Redmine\Connections\Connection;
use Aedart\Redmine\Exceptions\InvalidConnection;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;

/**
 * ConnectionTest
 *
 * @group redmine
 * @group redmine-connection
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Redmine\Connections
 */
class ConnectionTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws ConnectionException
     */
    public function canResolveDefaultConnection()
    {
        $connection = Connection::resolve();

        $this->assertNotNull($connection);
    }

    /**
     * @test
     *
     * @throws ConnectionException
     */
    public function canResolveRequestedConnection()
    {
        $connection = Connection::resolve('my_custom_connection');

        $this->assertNotNull($connection);
    }

    /**
     * @test
     *
     * @throws ConnectionException
     */
    public function resolvesGivenConnection()
    {
        $custom = Connection::resolve('my_custom_connection');

        $connection = Connection::resolve($custom);

        $this->assertSame($custom, $connection);
    }

    /**
     * @test
     *
     * @throws ConnectionException
     */
    public function canObtainHttpClient()
    {
        $client = Connection::resolve()->client();

        $this->assertInstanceOf(Client::class, $client);
    }

    /**
     * @test
     *
     * @throws ConnectionException
     */
    public function failsResolveWhenInvalidTypeGiven()
    {
        $this->expectException(InvalidConnection::class);

        Connection::resolve(true);
    }

    /**
     * @test
     *
     * @throws ConnectionException
     */
    public function failsWhenConnectionProfileDoesNotExist()
    {
        $this->expectException(InvalidConnection::class);

        $connection = Connection::resolve('unknown_connection_profile');
        $connection->client();
    }

    /**
     * @test
     *
     * @throws ConnectionException
     */
    public function failsWhenHttpClientProfileDoesNotExist()
    {
        $this->expectException(InvalidConnection::class);

        $connection = Connection::resolve('connection_with_invalid_http_client');
        $connection->client();
    }
}
