<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Streams\Stream;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * D2_ReadLinesTest
 *
 * @group streams
 * @group streams-d2
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
#[Group(
    'streams',
    'stream-d2',
)]
class D2_ReadLinesTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canReadSingleLine()
    {
        $content = "a\nb\nc\n";
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $content);

        $stream = Stream::make($resource)
            ->positionToStart();

        $resultA = $stream->readLine();
        $resultB = $stream->readLine();
        $resultC = $stream->readLine();

        // Note: readLine also returns new line char!
        $this->assertSame('a', trim($resultA));
        $this->assertSame('b', trim($resultB));
        $this->assertSame('c', trim($resultC));
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canReadSingleLineWithLengthLimitation()
    {
        $content = "aaa\nbbb\nccc\n";
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $content);

        $stream = Stream::make($resource)
            ->positionToStart();

        $resultA = $stream->readLine(3);
        $resultB = $stream->readLine(3);
        $resultC = $stream->readLine(3);

        // Note: results may seem off... but this is how the fgets behaves!
        $this->assertSame('aa', trim($resultA));
        $this->assertSame('a', trim($resultB));
        $this->assertSame('bb', trim($resultC));
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canReadAllLines()
    {
        $content = "a\nb\nc\n";
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $content);

        $stream = Stream::make($resource)
            ->positionToStart();

        $buffer = '';
        $iterator = $stream->readAllLines();
        foreach ($iterator as $line) {
            ConsoleDebugger::output($line);

            $buffer .= $line;
        }

        // Note: readAllLines trims all newline chars !
        $this->assertSame('abc', $buffer);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canIterateThroughStreamLines()
    {
        $content = "a\nb\nc\n";
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $content);

        $stream = Stream::make($resource)
            ->positionToStart();

        $buffer = '';
        foreach ($stream as $line) {
            ConsoleDebugger::output($line);

            $buffer .= $line;
        }

        // Note: readAllLines trims all newline chars !
        $this->assertSame('abc', $buffer);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canReadSingleLineUntilDelimiter()
    {
        $content = "a;b;c;";
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $content);

        $stream = Stream::make($resource)
            ->positionToStart();

        $length = 5;
        $delimiter = ';';

        $resultA = $stream->readLineUntil($length, $delimiter);
        $resultB = $stream->readLineUntil($length, $delimiter);
        $resultC = $stream->readLineUntil($length, $delimiter);

        $this->assertSame('a', $resultA);
        $this->assertSame('b', $resultB);
        $this->assertSame('c', $resultC);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canReadAllLinesUntilDelimiter()
    {
        $content = "aa||bb||cc";
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $content);

        $stream = Stream::make($resource)
            ->positionToStart();

        $buffer = '';
        $iterator = $stream->readAllUsingDelimiter(10, '||');
        foreach ($iterator as $line) {
            ConsoleDebugger::output($line);

            $buffer .= $line;
        }

        $this->assertSame('aabbcc', $buffer);
    }
}
