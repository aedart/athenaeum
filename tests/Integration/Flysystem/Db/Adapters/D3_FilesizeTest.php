<?php

namespace Aedart\Tests\Integration\Flysystem\Db\Adapters;

use Aedart\Tests\TestCases\Flysystem\Db\FlysystemDbTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * D3_FilesizeTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Flysystem\Db\Adapters
 */
#[Group(
    'flysystem',
    'flysystem-db',
    'flysystem-db-d3'
)]
class D3_FilesizeTest extends FlysystemDbTestCase
{
    /**
     * @return void
     *
     * @throws \League\Flysystem\FilesystemException
     */
    #[Test]
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
