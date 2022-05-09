<?php

namespace Aedart\Tests\Integration\Flysystem\Db\Adapters;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Flysystem\Db\FlysystemDbTestCase;
use Codeception\Configuration;

/**
 * D1_FileMimeTypeTest
 *
 * @group flysystem
 * @group flysystem-db
 * @group flysystem-db-d1
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Flysystem\Db\Adapters
 */
class D1_FileMimeTypeTest extends FlysystemDbTestCase
{
    /**
     * @test
     *
     * @return void
     *
     * @throws \League\Flysystem\FilesystemException
     */
    public function canDetermineMimeTypeForFile(): void
    {
        $path = 'home/books/october_falls.txt';
        $content = fopen(Configuration::dataDir() . 'mime-types/files/test.rtf', 'rb');

        // ----------------------------------------------------------------- //

        $fs = $this->filesystem();
        $fs->writeStream($path, $content);

        // ----------------------------------------------------------------- //

        $result = $fs->mimeType($path);

        ConsoleDebugger::output($result);

        $this->assertSame('text/rtf', $result);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws \League\Flysystem\FilesystemException
     */
    public function canSpecifyCustomMimeType(): void
    {
        $path = 'home/books/october_falls.txt';
        $content = $this->getFaker()->sentence();

        // ----------------------------------------------------------------- //

        $customMimeType = 'application/ext-custom';

        $fs = $this->filesystem();
        $fs->write($path, $content, [
            'mime_type' => $customMimeType
        ]);

        // ----------------------------------------------------------------- //

        $result = $fs->mimeType($path);

        $this->assertSame($customMimeType, $result);
    }
}