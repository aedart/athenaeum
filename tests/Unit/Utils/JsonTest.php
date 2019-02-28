<?php

namespace Aedart\Tests\Unit\Utils;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Json;

/**
 * JsonTest
 *
 * @group utils
 * @group utils-json
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils
 */
class JsonTest extends UnitTestCase
{
    /**
     * @test
     */
    public function canEncodeAndDecodeJson()
    {
        $data = [
            'name'  => $this->faker->name,
            'age'   => $this->faker->randomNumber()
        ];

        $encoded = Json::encode($data);
        ConsoleDebugger::output($encoded);
        $this->assertJson($encoded);

        // ------------------------------------ //
        $decoded = Json::decode($encoded, true);
        ConsoleDebugger::output($decoded);

        $this->assertArrayHasKey('name', $decoded);
        $this->assertSame($data['name'], $decoded['name']);

        $this->assertArrayHasKey('age', $decoded);
        $this->assertSame($data['age'], $decoded['age']);
    }

    /**
     * @test
     * @expectedException \Aedart\Utils\Exceptions\JsonEncoding
     */
    public function failsEncodingJson()
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        Json::encode($socket);
    }

    /**
     * @test
     * @expectedException \Aedart\Utils\Exceptions\JsonEncoding
     */
    public function failsDecodingJson()
    {
        $json = '{"name:fisk';

        Json::decode($json);
    }
}
