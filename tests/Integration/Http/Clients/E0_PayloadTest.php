<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Aedart\Utils\Json;
use GuzzleHttp\Psr7\Response;
use JsonException;

/**
 * E0_PayloadTest
 *
 * @group http-clients
 * @group http-clients-e0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
class E0_PayloadTest extends HttpClientsTestCase
{
    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     * @throws JsonException
     */
    public function canSetDataViaTheBuilder(string $profile)
    {
        $client = $this->client($profile);

        $data = [
            'name' => 'Jim Carter'
        ];

        $client
            ->withOption('handler', $this->makeRespondsOkMock())
            ->jsonFormat()
            ->withData($data)
            ->post('/users');

        $sentBody = $this->lastRequest->getBody()->getContents();
        ConsoleDebugger::output($sentBody);

        $decoded = Json::decode($sentBody, true);

        $this->assertArrayHasKey('name', $decoded);
        $this->assertSame($data['name'], $decoded['name']);
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     * @throws JsonException
     */
    public function mergesMultipleDataSources(string $profile)
    {
        $client = $this->client($profile);

        $dataA = [ 'name' => 'Sven Wolfson' ];
        $dataB = [ 'age' => 37 ];
        $dataC = [ 'address' => 'Griswalt Street 3' ];

        $client
            ->withOption('handler', $this->makeRespondsOkMock())
            ->jsonFormat()
            ->withData($dataA)
            ->withData($dataB)
            ->post('/users', $dataC);

        $sentBody = $this->lastRequest->getBody()->getContents();
        ConsoleDebugger::output($sentBody);

        $decoded = Json::decode($sentBody, true);

        $this->assertArrayHasKey('name', $decoded);
        $this->assertSame($dataA['name'], $decoded['name']);

        $this->assertArrayHasKey('age', $decoded);
        $this->assertSame($dataB['age'], $decoded['age']);

        $this->assertArrayHasKey('address', $decoded);
        $this->assertSame($dataC['address'], $decoded['address']);
    }
}