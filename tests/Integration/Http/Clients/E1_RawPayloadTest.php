<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\Attributes\Test;

/**
 * E1_RawPayloadTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-e1',
)]
class E1_RawPayloadTest extends HttpClientsTestCase
{
    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function extractsRawPayloadFromOptions(string $profile)
    {
        $payload = '<p>When the cannon falls for puerto rico, all lads hail swashbuckling, weird scabbards.</p>';

        $client = $this->client($profile, [
            'body' => $payload
        ]);

        $this->assertTrue($client->hasRawPayload(), 'No raw payload detected in options');
        $this->assertSame($payload, $client->getRawPayload(), 'Incorrect raw payload');
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
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
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
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
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
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
