<?php

namespace Aedart\Tests\Integration\Streams\File;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Streams\StreamTestCase;

/**
 * G1_FilenameTest
 *
 * @group streams
 * @group streams-file-g1
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams\File
 */
class G1_FilenameTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     *
     * @throws StreamException
     */
    public function returnsFilenameFromMeta(): void
    {
        $filename = 'my_file.txt';

        $stream = $this->openFileStreamFor('text.txt');
        $stream->meta()->set('filename', $filename);

        $result = $stream->filename();
        ConsoleDebugger::output($result);

        $this->assertSame($filename, $result);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws StreamException
     */
    public function returnsFilenameFromUri(): void
    {
        $filename = 'text.txt';
        $stream = $this->openFileStreamFor($filename);

        $result = $stream->filename();
        ConsoleDebugger::output($result);

        $this->assertSame($filename, $result);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws StreamException
     */
    public function returnsNullIfUriUnknown(): void
    {
        $stream = $this->openFileStreamFor('text.txt');

        // Detach and clear meta repository
        $stream->detach();
        $stream->setMetaRepository([]);

        $result = $stream->filename();
        ConsoleDebugger::output($result);

        $this->assertNull($result);
    }
}
