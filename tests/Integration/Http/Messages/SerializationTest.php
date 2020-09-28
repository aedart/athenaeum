<?php

namespace Aedart\Tests\Integration\Http\Messages;

use Aedart\Contracts\Http\Messages\Exceptions\SerializationException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpSerializationTestCase;
use Aedart\Utils\Json;
use Teapot\StatusCode\Http;

/**
 * SerializationTest
 *
 * @group http
 * @group http-messages
 * @group http-message-serialisation
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Messages
 */
class SerializationTest extends HttpSerializationTestCase
{
    /**
     * @test
     */
    public function canObtainFactory()
    {
        $factory = $this->getHttpSerializerFactory();

        $this->assertNotNull($factory);
    }

    /**
     * @test
     *
     * @throws \Aedart\Contracts\Http\Messages\Exceptions\SerializationException
     */
    public function failsWhenInvalidHttpMessageProvided()
    {
        $this->expectException(SerializationException::class);

        $this
            ->getHttpSerializerFactory()
            ->make($this->makeInvalidHttpMessage());
    }

    /**
     * @test
     *
     * @throws SerializationException
     * @throws \JsonException
     */
    public function canSerializeRequest()
    {
        $request = $this->makeRequest(
            'GET',
            'https://acme.org/users?created_at=2020',
            [ 'Content-Type' => 'application/json' ],
            Json::encode([
                'users' => [
                    'Jim',
                    'Ulla',
                    'Brian'
                ]
            ]),
        );

        $factory = $this->getHttpSerializerFactory();

        $serialized = (string) $factory->make($request);
        ConsoleDebugger::output($serialized);

        $this->assertStringContainsString('GET', $serialized);
        $this->assertStringContainsString((string) $request->getUri()->getPath(), $serialized);
        $this->assertStringContainsString((string) $request->getUri()->getQuery(), $serialized);
        $this->assertStringContainsString('HTTP/1.1', $serialized);
        $this->assertStringContainsString('Host: acme.org', $serialized);
        $this->assertStringContainsString('Content-Type: application/json', $serialized);
        $this->assertStringContainsString((string) $request->getBody(), $serialized);
    }

    /**
     * @test
     *
     * @throws SerializationException
     * @throws \JsonException
     */
    public function canSerializeRequestToArray()
    {
        $request = $this->makeRequest(
            'GET',
            'https://acme.org/users?created_at=2020',
            [ 'Content-Type' => 'application/json' ],
            Json::encode([
                'users' => [
                    'Jim',
                    'Ulla',
                    'Brian'
                ]
            ]),
        );

        $factory = $this->getHttpSerializerFactory();

        $serialized = $factory->make($request)->toArray();
        ConsoleDebugger::output($serialized);
        dd($serialized);

        $this->assertArrayHasKey('method', $serialized);
        $this->assertSame('GET', $serialized['method']);

        $this->assertArrayHasKey('target', $serialized);
        $this->assertStringContainsString($request->getUri()->getPath(), $serialized['target']);
        $this->assertStringContainsString($request->getUri()->getQuery(), $serialized['target']);

        $this->assertArrayHasKey('uri', $serialized);
        $this->assertStringContainsString((string) $request->getUri(), $serialized['uri']);

        $this->assertArrayHasKey('protocol_version', $serialized);
        $this->assertSame($request->getProtocolVersion(), $serialized['protocol_version']);

        $this->assertArrayHasKey('headers', $serialized);
        $this->assertSame($request->getHeaders(), $serialized['headers']);

        $this->assertArrayHasKey('body', $serialized);
        $this->assertSame((string) $request->getBody(), $serialized['body']);
    }

    /**
     * @test
     *
     * @throws SerializationException
     * @throws \JsonException
     */
    public function canSerializeResponse()
    {
        $response = $this->makeResponse(
            Http::CREATED,
            [ 'Content-Type' => 'application/json' ],
            Json::encode([
                'id' => 458712,
                'name' => 'Sven Jr.',
                'age' => 27
            ]),
        );

        $factory = $this->getHttpSerializerFactory();

        $serialized = (string) $factory->make($response);
        ConsoleDebugger::output($serialized);

        $this->assertStringContainsString('HTTP/1.1', $serialized);
        $this->assertStringContainsString($response->getStatusCode(), $serialized);
        $this->assertStringContainsString($response->getReasonPhrase(), $serialized);
        $this->assertStringContainsString('Content-Type: application/json', $serialized);
        $this->assertStringContainsString((string) $response->getBody(), $serialized);
    }

    /**
     * @test
     *
     * @throws SerializationException
     * @throws \JsonException
     */
    public function canSerializeResponseToArray()
    {
        $response = $this->makeResponse(
            Http::CREATED,
            [ 'Content-Type' => 'application/json' ],
            Json::encode([
                'id' => 458712,
                'name' => 'Sven Jr.',
                'age' => 27
            ]),
        );

        $factory = $this->getHttpSerializerFactory();

        $serialized = $factory->make($response)->toArray();
        ConsoleDebugger::output($serialized);

        $this->assertArrayHasKey('status', $serialized);
        $this->assertSame($response->getStatusCode(), $serialized['status']);

        $this->assertArrayHasKey('reason', $serialized);
        $this->assertSame($response->getReasonPhrase(), $serialized['reason']);

        $this->assertArrayHasKey('protocol_version', $serialized);
        $this->assertSame($response->getProtocolVersion(), $serialized['protocol_version']);

        $this->assertArrayHasKey('headers', $serialized);
        $this->assertSame($response->getHeaders(), $serialized['headers']);

        $this->assertArrayHasKey('body', $serialized);
        $this->assertSame((string) $response->getBody(), $serialized['body']);
    }
}
