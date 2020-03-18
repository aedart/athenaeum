<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use GuzzleHttp\RequestOptions;

/**
 * E1_RawPayloadTest
 *
 * @group http-clients
 * @group http-clients-e1
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
class E1_RawPayloadTest extends HttpClientsTestCase
{
    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function canSetTheRawPayload(string $profile)
    {
        $client = $this->client($profile);

        $body = '<p>Sweet</p>';

        $client
            ->withOption('handler', $this->makeRespondsOkMock())
            ->withRawPayload($body)
            ->post('/content');

        $sentBody = $this->lastRequest->getBody()->getContents();
        ConsoleDebugger::output($sentBody);

        $this->assertSame($body, $sentBody);
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function favoursRawPayloadFromOptions(string $profile)
    {
        $client = $this->client($profile);

        $bodyA = '<p>Sweet</p>';
        $bodyB = '<p>Due</p>';

        $client
            ->withOption('handler', $this->makeRespondsOkMock())
            ->withRawPayload($bodyA)
            ->withOption(RequestOptions::BODY, $bodyB) // Only other way to set raw body
            ->post('/content'); // Method only accepts array...

        $sentBody = $this->lastRequest->getBody()->getContents();
        ConsoleDebugger::output($sentBody);

        $this->assertSame($bodyB, $sentBody);
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function ignoresArrayDataIfRawPayloadSet(string $profile)
    {
        $client = $this->client($profile);

        $body = '<p>Louise Lane</p>';

        $client
            ->withOption('handler', $this->makeRespondsOkMock())
            ->jsonFormat()
            ->withData([ 'name' => 'Jane Jr.' ])
            ->withRawPayload($body)
            ->post('/users');

        $sentBody = $this->lastRequest->getBody()->getContents();
        ConsoleDebugger::output($sentBody);

        $this->assertIsString($sentBody);
        $this->assertSame($body, $sentBody);
    }
}
