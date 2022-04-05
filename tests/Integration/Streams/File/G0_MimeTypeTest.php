<?php

namespace Aedart\Tests\Integration\Streams\File;

use Aedart\Streams\FileStream;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Streams\StreamTestCase;

/**
 * G0_MimeTypeTest
 *
 * @group streams
 * @group streams-file-g0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams\File
 */
class G0_MimeTypeTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     *
     * @throws \Aedart\Contracts\MimeTypes\Exceptions\MimeTypeDetectionException
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canDetectStreamMimeType()
    {
        $stream = FileStream::makeFrom(
            $this->makeTextFileStream()
        );

        $mimeType = $stream->mimeType();

        ConsoleDebugger::output($mimeType);

        $this->assertSame('text/plain', $mimeType->type());
    }
}
