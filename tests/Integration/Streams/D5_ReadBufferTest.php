<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Contracts\Streams\BufferSizes;
use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Streams\Stream;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Aedart\Utils\Str;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * D5_ReadBufferTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
#[Group(
    'streams',
    'stream-d5',
)]
class D5_ReadBufferTest extends StreamTestCase
{
    /**
     * @return void
     *
     * @throws StreamException
     */
    #[Test]
    public function canBufferStream(): void
    {
        $content = Str::random(50);
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $content);
        $stream = Stream::make($resource);

        // -------------------------------------------------------------------- //

        $length = null;
        $offset = 0;
        $bufferSize = BufferSizes::BUFFER_8KB;

        $iterator = $stream->buffer($length, $offset, $bufferSize);

        // -------------------------------------------------------------------- //

        $buffer = '';
        $iterations = 0;
        foreach ($iterator as $chunk) {
            ConsoleDebugger::output($chunk);

            $buffer .= $chunk;
            $iterations++;
        }

        $expected = substr($content, $offset, $length);
        $this->assertSame($expected, $buffer);

        $expectedIterations = (int) ceil(strlen($content) / $bufferSize);
        $this->assertSame($expectedIterations, $iterations, 'Incorrect amount of iterations');
    }

    /**
     * @return void
     *
     * @throws StreamException
     */
    #[Test]
    public function canBufferLength(): void
    {
        $content = Str::random(50);
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $content);
        $stream = Stream::make($resource);

        // -------------------------------------------------------------------- //

        $length = 25;
        $offset = 0;
        $bufferSize = BufferSizes::BUFFER_8KB;

        $iterator = $stream->buffer($length, $offset, $bufferSize);

        // -------------------------------------------------------------------- //

        $buffer = '';
        $iterations = 0;
        foreach ($iterator as $chunk) {
            ConsoleDebugger::output($chunk);

            $buffer .= $chunk;
            $iterations++;
        }

        $expected = substr($content, $offset, $length);
        $this->assertSame($expected, $buffer);

        $expectedIterations = (int) ceil($length / $bufferSize);
        $this->assertSame($expectedIterations, $iterations, 'Incorrect amount of iterations');
    }

    /**
     * @return void
     *
     * @throws StreamException
     */
    #[Test]
    public function canBufferFromOffset(): void
    {
        $content = Str::random(50);
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $content);
        $stream = Stream::make($resource);

        // -------------------------------------------------------------------- //

        $length = 11;
        $offset = 22;
        $bufferSize = BufferSizes::BUFFER_8KB;

        $iterator = $stream->buffer($length, $offset, $bufferSize);

        // -------------------------------------------------------------------- //

        $buffer = '';
        $iterations = 0;
        foreach ($iterator as $chunk) {
            ConsoleDebugger::output($chunk);

            $buffer .= $chunk;
            $iterations++;
        }

        $expected = substr($content, $offset, $length);
        $this->assertSame($expected, $buffer);

        $expectedIterations = (int) ceil($length / $bufferSize);
        $this->assertSame($expectedIterations, $iterations, 'Incorrect amount of iterations');
    }

    /**
     * @return void
     *
     * @throws StreamException
     */
    #[Test]
    public function canBufferUsingSpecificBufferSize(): void
    {
        $content = Str::random(50);
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $content);
        $stream = Stream::make($resource);

        // -------------------------------------------------------------------- //

        $length = 11;
        $offset = 22;
        $bufferSize = 3;

        $iterator = $stream->buffer($length, $offset, $bufferSize);

        // -------------------------------------------------------------------- //

        $buffer = '';
        $iterations = 0;
        foreach ($iterator as $chunk) {
            ConsoleDebugger::output($chunk);

            $buffer .= $chunk;
            $iterations++;
        }

        $expected = substr($content, $offset, $length);
        ConsoleDebugger::output('Final buffer: ' . $buffer);
        $this->assertSame($expected, $buffer);

        $expectedIterations = (int) ceil($length / $bufferSize);
        $this->assertSame($expectedIterations, $iterations, 'Incorrect amount of iterations');
    }

    /**
     * @return void
     *
     * @throws StreamException
     */
    #[Test]
    public function doesNotExceedLengthWhenBufferSizeExceedsRemaining(): void
    {
        $content = Str::random(50);
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $content);
        $stream = Stream::make($resource);

        // -------------------------------------------------------------------- //

        $length = 8;
        $offset = 22;

        // 2 x 5 = 10, meaning that last chunk size MUST be reduced,
        // or too much data will be read...
        $bufferSize = 5;

        $iterator = $stream->buffer($length, $offset, $bufferSize);

        // -------------------------------------------------------------------- //

        $buffer = '';
        $iterations = 0;
        foreach ($iterator as $chunk) {
            ConsoleDebugger::output($chunk);

            $buffer .= $chunk;
            $iterations++;
        }

        $expected = substr($content, $offset, $length);
        ConsoleDebugger::output('Final buffer: ' . $buffer);
        $this->assertSame($expected, $buffer);

        $expectedIterations = (int) ceil($length / $bufferSize);
        $this->assertSame($expectedIterations, $iterations, 'Incorrect amount of iterations');
    }
}
