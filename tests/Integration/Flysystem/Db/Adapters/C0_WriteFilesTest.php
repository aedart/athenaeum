<?php

namespace Aedart\Tests\Integration\Flysystem\Db\Adapters;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Flysystem\Db\FlysystemDbTestCase;

/**
 * C0_WriteFilesTest
 *
 * @group flysystem
 * @group flysystem-db
 * @group flysystem-db-c0
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Flysystem\Db\Adapters
 */
class C0_WriteFilesTest extends FlysystemDbTestCase
{
    /**
     * @test
     *
     * @return void
     *
     * @throws \League\Flysystem\FilesystemException
     */
    public function canWriteAndReadFile(): void
    {
        $path = 'home/books/october_falls.txt';
        $content = $this->getFaker()->sentence();

        // ----------------------------------------------------------------- //

        $fs = $this->filesystem();

        $fs->write($path, $content);
        $result = $fs->read($path);

        ConsoleDebugger::output($result);

        // ----------------------------------------------------------------- //
        // Ensure file content is the same

        $this->assertTrue($fs->has($path));
        $this->assertSame($content, $result);

        // ----------------------------------------------------------------- //
        // Ensure directories are created as intended

        $this->assertTrue($fs->directoryExists('home/books'), 'Nested directory does not appear to exist');
        $this->assertTrue($fs->directoryExists('home'), 'Root level directory does not appear to exist');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws \League\Flysystem\FilesystemException
     */
    public function canDeduplicateContent(): void
    {
        $pathA = 'home/books/october_falls.txt';
        $pathB = 'home/books/copies/falls.txt';
        $content = $this->getFaker()->sentence();

        // ----------------------------------------------------------------- //

        $fs = $this->filesystem();

        $fs->write($pathA, $content);
        $fs->write($pathB, $content);

        // ----------------------------------------------------------------- //

        $contentsList = $this->fetchAllFileContents();

        ConsoleDebugger::output($contentsList);

        $this->assertCount(1, $contentsList, 'Incorrect amount of contents persisted in database');
        $this->assertSame(2, (int) $contentsList[0]->reference_count, 'Invalid reference_count');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws \League\Flysystem\FilesystemException
     */
    public function decreasesReferenceCount(): void
    {
        $pathA = 'home/books/october_falls.txt';
        $pathB = 'home/books/copies/falls.txt';
        $pathC = 'home/books/other_copies/tmp.txt';
        $content = $this->getFaker()->sentence();

        // ----------------------------------------------------------------- //

        $fs = $this->filesystem();

        $fs->write($pathA, $content);
        $fs->write($pathB, $content);
        $fs->write($pathC, $content);

        // ----------------------------------------------------------------- //
        // Remove files, that has "deduplicated" content

        $fs->delete($pathA);
        $fs->delete($pathC);

        // ----------------------------------------------------------------- //

        $contentsList = $this->fetchAllFileContents();

        ConsoleDebugger::output($contentsList);

        $this->assertCount(1, $contentsList, 'Incorrect amount of contents persisted in database');
        $this->assertSame(1, (int) $contentsList[0]->reference_count, 'Invalid reference_count');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws \League\Flysystem\FilesystemException
     */
    public function cleanupWhenReferenceCountBecomesZero(): void
    {
        $pathA = 'home/books/october_falls.txt';
        $pathB = 'home/books/copies/falls.txt';
        $pathC = 'home/books/other_copies/tmp.txt';
        $content = $this->getFaker()->sentence();

        // ----------------------------------------------------------------- //

        $fs = $this->filesystem();

        $fs->write($pathA, $content);
        $fs->write($pathB, $content);
        $fs->write($pathC, $content);

        // ----------------------------------------------------------------- //
        // Remove files, that has "deduplicated" content

        $fs->delete($pathA);
        $fs->delete($pathB);
        $fs->delete($pathC);

        // ----------------------------------------------------------------- //

        $contentsList = $this->fetchAllFileContents();

        $this->assertCount(0, $contentsList, 'Incorrect amount of contents persisted in database');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws \League\Flysystem\FilesystemException
     */
    public function canUpdateFile(): void
    {
        $faker = $this->getFaker();

        $path = 'home/books/october_falls.txt';
        $contentA = $faker->unique()->sentence();
        $contentB = $faker->unique()->sentence();

        // ----------------------------------------------------------------- //

        $fs = $this->filesystem();

        $fs->write($path, $contentA);

        // Update file with new content
        $fs->write($path, $contentB);

        // ----------------------------------------------------------------- //

        $contentsList = $this->fetchAllFileContents();

        $this->assertCount(1, $contentsList, 'Incorrect amount of contents persisted in database');
        $this->assertSame(1, (int) $contentsList[0]->reference_count, 'Invalid reference_count');

        $this->assertSame($contentB, $fs->read($path), 'Incorrect content retrieved via filesystem');
        $this->assertSame($contentB, $contentsList[0]->contents, 'Incorrect content in contents-table!');
    }
}
