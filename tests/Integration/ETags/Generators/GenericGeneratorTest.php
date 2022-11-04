<?php

namespace Aedart\Tests\Integration\ETags\Generators;

use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\ETags\Exceptions\ETagGeneratorException;
use Aedart\Contracts\ETags\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\ETags\ETagsTestCase;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

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
        $arrayableClass = new class implements Arrayable {
            public function toArray()
            {
                return [ 1, 2, 3];
            }
        };

        $jsonableClass = new class implements Jsonable {
            public function toJson($options = 0)
            {
                return json_encode([ true ], $options);
            }
        };

        return [
            'string' => [ 'Lorum Lipsum' ],
            'int' => [ 32574 ],
            'float' => [ 12.7 ],
            'bool (true)' => [ true ],
            'bool (false)' => [ false ],
            'array' => [
                [ 'a', 123, '56' ]
            ],
            'arrayable' => [ new $arrayableClass() ],
            'jsonable' => [ new $jsonableClass() ]
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @dataProvider dataProvider
     *
     * @param  mixed  $content
     *
     * @return void
     *
     * @throws ETagGeneratorException
     * @throws ProfileNotFoundException
     */
    public function canMakeETag(mixed $content): void
    {
        $generator = $this->makeGenerator('default');

        $eTag = $generator->make($content);

        ConsoleDebugger::output($eTag);

        $this->assertInstanceOf(ETag::class, $eTag);
        $this->assertNotEmpty($eTag->raw());
    }
}