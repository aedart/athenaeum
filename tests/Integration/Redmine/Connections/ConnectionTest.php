<?php

namespace Aedart\Tests\Integration\Redmine\Connections;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Redmine\Exceptions\ConnectionException;
use Aedart\Redmine\Connections\Connection;
use Aedart\Redmine\Exceptions\InvalidConnection;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Aedart\Utils\Json;

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
     * @throws \JsonException
     */
    public function canMockResponse()
    {
        $data = [
            'name' => 'Timmy J. Olsen'
        ];

        $connection = Connection::resolve()->mock(
            $this->mockJsonResponse($data)
        );

        $response = $connection
                ->client()
                ->get('something');

        $content = Json::decode($response->getBody()->getContents(), true);

        ConsoleDebugger::output($content);

        $this->assertIsArray($content, 'Decoded content is not an array');
        $this->assertArrayHasKey('name', $content, 'Incorrect content');
        $this->assertSame($data['name'], $content['name'], 'Incorrect value decoded');
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
