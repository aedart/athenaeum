<?php

namespace Aedart\Tests\Integration\Flysystem\Db\Adapters;

use Aedart\Flysystem\Db\Adapters\DatabaseAdapter;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Flysystem\Db\FlysystemDbTestCase;
use Codeception\Attribute\Group;
use Codeception\Configuration;
use PHPUnit\Framework\Attributes\Test;

/**
 * D1_FileMimeTypeTest
 *
 * @group flysystem
 * @group flysystem-db
 * @group flysystem-db-d1
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Flysystem\Db\Adapters
 */
#[Group(
    'flysystem',
    'flysystem-db',
    'flysystem-db-d1'
)]
class D1_FileMimeTypeTest extends FlysystemDbTestCase
{
    /**
     * @test
     *
     * @return void
     *
     * @throws \League\Flysystem\FilesystemException
     */
    #[Test]
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
    #[Test]
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

    /**
     * @test
     *
     * @return void
     *
     * @throws \League\Flysystem\FilesystemException
     */
    #[Test]
    public function canSetCustomDetectCallback(): void
    {
        $path = 'home/books/october_falls.txt';
        $content = $this->getFaker()->sentence();

        // ----------------------------------------------------------------- //

        $customMimeType = 'application/ext-other';
        $adapter = new DatabaseAdapter('files', 'file_contents');
        $adapter->detectMimeTypeUsing(function () use ($customMimeType) {
            return $customMimeType;
        });

        $fs = $this->filesystem('', $adapter);
        $fs->write($path, $content);

        // ----------------------------------------------------------------- //

        $result = $fs->mimeType($path);

        $this->assertSame($customMimeType, $result);
    }
}
