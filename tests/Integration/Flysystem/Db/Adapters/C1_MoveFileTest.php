<?php

namespace Aedart\Tests\Integration\Flysystem\Db\Adapters;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Flysystem\Db\FlysystemDbTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * C1_MoveFileTest
 *
 * @group flysystem
 * @group flysystem-db
 * @group flysystem-db-c1
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Flysystem\Db\Adapters
 */
#[Group(
    'flysystem',
    'flysystem-db',
    'flysystem-db-c1'
)]
class C1_MoveFileTest extends FlysystemDbTestCase
{
    /**
     * @test
     *
     * @return void
     *
     * @throws \League\Flysystem\FilesystemException
     */
    #[Test]
    public function canMoveFile(): void
    {
        $pathA = 'home/books/october_falls.txt';
        $pathB = 'home/best_sellers/october_falls.txt';
        $content = $this->getFaker()->sentence();

        // ----------------------------------------------------------------- //

        $fs = $this->filesystem();

        $fs->write($pathA, $content);

        // Move file
        $fs->move($pathA, $pathB);

        // ----------------------------------------------------------------- //

        $this->assertFalse($fs->fileExists($pathA), 'Path A should no longer exists');
        $this->assertTrue($fs->fileExists($pathB), 'Path B does not exist');

        // ----------------------------------------------------------------- //
        // Ensure that "contents record" has correct reference count!

        $contentsList = $this->fetchAllFileContents();

        ConsoleDebugger::output($contentsList);

        $this->assertCount(1, $contentsList, 'Incorrect amount of contents persisted in database');
        $this->assertSame(1, (int) $contentsList[0]->reference_count, 'Invalid reference_count');
    }
}
