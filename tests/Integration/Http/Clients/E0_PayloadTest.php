<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Aedart\Utils\Json;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use JsonException;
use PHPUnit\Framework\Attributes\Test;

/**
 * E0_PayloadTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-e0',
)]
class E0_PayloadTest extends HttpClientsTestCase
{
    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function extractsFormInputDataFromOptions(string $profile)
    {
        $data = [
            'name' => 'Jessy',
            'age' => 29
        ];

        $client = $this->client($profile, [
            'form_params' => $data
        ]);

        $this->assertSame($data, $client->getData(), 'Incorrect data from options');
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function extractsJsonDataFromOptions(string $profile)
    {
        $data = [
            'name' => 'Ricky',
            'age' => 36
        ];

        $client = $this->client($profile, [
            'json' => $data
        ]);

        $this->assertSame($data, $client->getData(), 'Incorrect data from options');
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     * @throws JsonException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
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
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     * @throws JsonException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
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
