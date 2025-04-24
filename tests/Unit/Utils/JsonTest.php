<?php

namespace Aedart\Tests\Unit\Utils;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Json;
use Codeception\Attribute\Group;
use JsonException;
use PHPUnit\Framework\Attributes\Test;

/**
 * JsonTest
 *
 * @group utils
 * @group utils-json
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils
 */
#[Group(
    'utils',
    'utils-json',
)]
class JsonTest extends UnitTestCase
{
    /**
     * @test
     */
    #[Test]
    public function canEncodeAndDecodeJson()
    {
        $data = [
            'name' => $this->faker->name(),
            'age' => $this->faker->randomNumber()
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
     */
    #[Test]
    public function failsEncodingJson()
    {
        $this->expectException(JsonException::class);

        Json::encode(tmpfile());
    }

    /**
     * @test
     */
    #[Test]
    public function failsDecodingJson()
    {
        $this->expectException(JsonException::class);

        $json = '{"name:fisk';

        Json::decode($json);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws JsonException
     */
    #[Test]
    public function canDetermineIfValidJsonEncoded()
    {
        $validA = Json::encode('abc');
        $validB = '{ "name": "Sven" }';

        $invalidA = [];
        $invalidB = 'not_json_encoded';
        $invalidC = '{ "name": "Sven"';

        $this->assertTrue(Json::isValid($validA), 'should be valid');
        $this->assertTrue(Json::isValid($validB), 'well formed string should be valid');

        $this->assertFalse(Json::isValid($invalidA), 'array value should not be valid json!');
        $this->assertFalse(Json::isValid($invalidB), 'Pure string should not be valid json');
        $this->assertFalse(Json::isValid($invalidC), 'Malformed string should not be valid json');
    }
}
