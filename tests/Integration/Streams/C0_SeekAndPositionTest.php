<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Streams\Exceptions\StreamNotSeekable;
use Aedart\Streams\Stream;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * C0_SeekAndPositionTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
#[Group(
    'streams',
    'stream-c0',
)]
class C0_SeekAndPositionTest extends StreamTestCase
{
    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canDetermineIfSeekable()
    {
        $streamA = $this->makeTextFileStream();
        $streamB = Stream::make(fopen('php://output', ''));

        $this->assertTrue($streamA->isSeekable(), 'a should be seekable');
        $this->assertFalse($streamB->isSeekable(), 'b should not be seekable');
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canObtainPointPosition()
    {
        $streamA = $this->makeTextFileStream();

        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, 'foo');
        fseek($resource, 0, SEEK_END);

        $streamB = Stream::make($resource);

        $posA = $streamA->position();
        $posB = $streamB->position();

        ConsoleDebugger::output([
            'a_position' => $posA,
            'b_position' => $posB,
        ]);

        $this->assertSame(0, $posA, 'incorrect position for stream a');
        $this->assertSame(3, $posB, 'incorrect position for stream b');
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canRewind()
    {
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $this->getFaker()->word());
        fseek($resource, 0, SEEK_END);

        $stream = Stream::make($resource);
        $stream->rewind();

        $this->assertSame(0, $stream->position());
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canSetPositionToStart()
    {
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $this->getFaker()->word());
        fseek($resource, 0, SEEK_END);

        $stream = Stream::make($resource)
            ->positionToStart();

        $this->assertSame(0, $stream->position());
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canSetPositionToEnd()
    {
        $text = $this->getFaker()->word();
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $text);

        $stream = Stream::make($resource)
            ->positionToEnd();

        $this->assertSame(strlen($text), $stream->position());
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function failsSettingPositionWhenStreamNotSeekable()
    {
        $this->expectException(StreamNotSeekable::class);

        Stream::make(fopen('php://output', ''))
            ->positionToStart();
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canDetermineIfEndOfFile()
    {
        $streamA = $this->makeTextFileStream();

        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, 'aa');
        fseek($resource, 0, SEEK_SET);

        // Funny thing about EOL... you actually need to read something from
        // the stream, before the meta-data (internally in PHP) is updated.
        // Setting the position does not appear to be enough!
        while (!feof($resource)) {
            fgets($resource, 3);
        }

        $streamB = Stream::make($resource);

        $this->assertFalse($streamA->eof(), 'a should not be at end-of-file (EOF)');
        $this->assertTrue($streamB->eof(), 'b should not be at end-of-file (EOF)');
    }
}
