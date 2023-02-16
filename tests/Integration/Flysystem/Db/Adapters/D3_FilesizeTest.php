<?php

namespace Aedart\Tests\Integration\Flysystem\Db\Adapters;

use Aedart\Tests\TestCases\Flysystem\Db\FlysystemDbTestCase;

/**
 * D3_FilesizeTest
 *
 * @group flysystem
 * @group flysystem-db
 * @group flysystem-db-d3
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Flysystem\Db\Adapters
 */
class D3_FilesizeTest extends FlysystemDbTestCase
{
    /**
     * @test
     *
     * @return void
     *
     * @throws \League\Flysystem\FilesystemException
     */
    public function canObtainFileSize(): void
    {
        $path = 'home/books/october_falls.txt';
        $content = $this->getFaker()->sentence(200);

        // ----------------------------------------------------------------- //

        $fs = $this->filesystem();
        $fs->write($path, $content);

        // ----------------------------------------------------------------- //

        $result = $fs->fileSize($path);

        $this->assertSame(strlen($content), $result);
    }
}
