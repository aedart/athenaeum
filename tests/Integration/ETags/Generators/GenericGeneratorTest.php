<?php

namespace Aedart\Tests\Integration\ETags\Generators;

use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\ETags\Exceptions\ETagGeneratorException;
use Aedart\Contracts\ETags\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\ETags\ETagsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;
use PHPUnit\Framework\Attributes\Test;
use Stringable;

/**
 * GenericGeneratorTest
 *
 * @group etags
 * @group etags-generators
 * @group etags-generic-generator
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\ETags\Generators
 */
#[Group(
    'etags',
    'etags-generators',
    'etags-generic-generator'
)]
class GenericGeneratorTest extends ETagsTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Data Provider
     *
     * @return array
     */
    public function dataProvider(): array
    {
        $arrayableClass = new class() implements Arrayable {
            public function toArray()
            {
                return [ 1, 2, 3];
            }
        };

        $jsonableClass = new class() implements Jsonable {
            public function toJson($options = 0)
            {
                return json_encode([ true ], $options);
            }
        };

        $jsonSerializableClass = new class() implements JsonSerializable {
            public function jsonSerialize(): mixed
            {
                return 'something';
            }
        };

        $stringableClass = new class() implements Stringable {
            public function __toString(): string
            {
                return 'lipsum...';
            }
        };

        return [
            'string' => [ 'Lorum Lipsum' ],
            'string (whitespaces)' => [ '    ' ],
            'int' => [ 32574 ],
            'float' => [ 12.7 ],
            'bool (true)' => [ true ],
            'bool (false)' => [ false ],
            'array' => [
                [ 'a', 123, '56', [ 1, 2, 3 ] ]
            ],
            'arrayable class' => [ new $arrayableClass() ],
            'jsonable class' => [ new $jsonableClass() ],
            'json serializable class' => [ new $jsonSerializableClass() ],
            'stringable class' => [ new $stringableClass() ],

            // These should produce the same hash!
            'null' => [ null ],
            'string (empty)' => [ '' ],
            'array (empty)' => [ [] ],

            'int (zero)' => [ 0 ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider dataProvider
     *
     * @param  mixed  $content
     *
     * @return void
     *
     * @throws ETagGeneratorException
     * @throws ProfileNotFoundException
     */
    #[DataProvider('dataProvider')]
    #[Test]
    public function canMakeWeakETag(mixed $content): void
    {
        $eTag = $this->makeGenerator()->makeWeak($content);

        $this->assertInstanceOf(ETag::class, $eTag);
        $this->assertNotEmpty($eTag->raw());

        ConsoleDebugger::output((string) $eTag);
    }

    /**
     * @test
     * @dataProvider dataProvider
     *
     * @param  mixed  $content
     *
     * @return void
     *
     * @throws ETagGeneratorException
     * @throws ProfileNotFoundException
     */
    #[DataProvider('dataProvider')]
    #[Test]
    public function canMakeStrongETag(mixed $content): void
    {
        $eTag = $this->makeGenerator()->makeStrong($content);

        $this->assertInstanceOf(ETag::class, $eTag);
        $this->assertNotEmpty($eTag->raw());

        ConsoleDebugger::output((string) $eTag);
    }
}
