<?php

namespace Aedart\Tests\Integration\Streams\File;

use Aedart\Streams\FileStream;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * G0_MimeTypeTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams\File
 */
#[Group(
    'streams',
    'stream-file',
    'stream-file-g0',
)]
class G0_MimeTypeTest extends StreamTestCase
{
    /**
     * @return void
     *
     * @throws \Aedart\Contracts\MimeTypes\Exceptions\MimeTypeDetectionException
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
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
