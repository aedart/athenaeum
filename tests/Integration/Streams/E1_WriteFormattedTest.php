<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Streams\Stream;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * E1_WriteFormattedTest
 *
 * @group streams
 * @group streams-e1
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
#[Group(
    'streams',
    'stream-e1',
)]
class E1_WriteFormattedTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canWriteFormatted()
    {
        $resource = fopen('php://memory', 'r+b');
        $stream = Stream::make($resource);

        $faker = $this->getFaker();
        $a = $faker->word();
        $b = $faker->word();
        $c = $faker->word();

        $bytesWritten = $stream->writeFormatted('<<%s, %s, %s>>', $a, $b, $c);
        $expected = "<<{$a}, {$b}, {$c}>>";

        ConsoleDebugger::output([
            'a' => $a,
            'b' => $b,
            'c' => $c,
            'expected' => $expected,
            'stream' => (string) $stream
        ]);

        $this->assertSame(strlen($expected), $bytesWritten);
        $this->assertSame($expected, (string) $stream);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canWriteFormattedViaPutFormatted()
    {
        $resource = fopen('php://memory', 'r+b');
        $stream = Stream::make($resource);

        $faker = $this->getFaker();
        $a = $faker->word();
        $b = $faker->word();
        $c = $faker->word();
        $d = $faker->word();

        $stream
            ->putFormatted('<<%s>>', $a)
            ->putFormatted('|%s-%s|', $b, $c)
            ->putFormatted('<<%s>>', $d);

        $expected = "<<{$a}>>|{$b}-{$c}|<<{$d}>>";

        ConsoleDebugger::output([
            'a' => $a,
            'b' => $b,
            'c' => $c,
            'd' => $d,
            'expected' => $expected,
            'stream' => (string) $stream
        ]);

        $this->assertSame($expected, (string) $stream);
    }
}
