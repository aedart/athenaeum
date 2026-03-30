<?php

namespace Aedart\Tests\Integration\Flysystem\Db\Adapters;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Flysystem\Db\FlysystemDbTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * C2_CopyFileTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Flysystem\Db\Adapters
 */
#[Group(
    'flysystem',
    'flysystem-db',
    'flysystem-db-c2'
)]
class C2_CopyFileTest extends FlysystemDbTestCase
{
    /**
     * @return void
     *
     * @throws \League\Flysystem\FilesystemException
     */
    #[Test]
    public function canCopyFile(): void
    {
        $pathA = 'home/books/october_falls.txt';
        $pathB = 'home/best_sellers/october_falls.txt';
        $content = $this->getFaker()->sentence();

        // ----------------------------------------------------------------- //

        $fs = $this->filesystem();

        $fs->write($pathA, $content);

        // Copy file
        $fs->copy($pathA, $pathB);

        // ----------------------------------------------------------------- //

        $this->assertTrue($fs->fileExists($pathA), 'Path A does not exist');
        $this->assertTrue($fs->fileExists($pathB), 'Path B does not exist');

        // ----------------------------------------------------------------- //
        // Ensure that "contents record" has correct reference count!

        $contentsList = $this->fetchAllFileContents();

        ConsoleDebugger::output($contentsList);

        $this->assertCount(1, $contentsList, 'Incorrect amount of contents persisted in database');
        $this->assertSame(2, (int) $contentsList[0]->reference_count, 'Invalid reference_count');
    }
}
