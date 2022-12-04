<?php

namespace Aedart\Tests\Integration\Flysystem\Db\Adapters;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Flysystem\Db\FlysystemDbTestCase;

/**
 * E0_FilesAndDirectoryListing
 *
 * @group flysystem
 * @group flysystem-db
 * @group flysystem-db-e0
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Flysystem\Db\Adapters
 */
class E0_FilesAndDirectoryListingTest extends FlysystemDbTestCase
{
    /**
     * @test
     *
     * @return void
     *
     * @throws \League\Flysystem\FilesystemException
     */
    public function canListDirectoriesAndFiles(): void
    {
        $directories = [
            'home/projects/a/src',
            'home/projects/b/src',
            'home/projects/c/src',
            'home/utils',
        ];

        $this->createDirectories($directories);

        // ---------------------------------------------------------------- //

        $pathA = 'home/projects/a/README.txt';
        $pathB = 'home/projects/a/src/book.txt';

        $pathC = 'home/projects/b/README.txt';
        $pathD = 'home/projects/b/src/book.txt';

        $pathE = 'home/projects/c/README.txt';
        $pathF = 'home/projects/c/src/book.txt';

        $fs = $this->filesystem();

        $fs->write($pathA, $this->getFaker()->sentence());
        $fs->write($pathB, $this->getFaker()->sentence());
        $fs->write($pathC, $this->getFaker()->sentence());
        $fs->write($pathD, $this->getFaker()->sentence());
        $fs->write($pathE, $this->getFaker()->sentence());
        $fs->write($pathF, $this->getFaker()->sentence());

        // ---------------------------------------------------------------- //
        // List directories inside "project a"

        $list = $this
            ->filesystem()
            ->listContents('home/projects/a')
            ->toArray();

        ConsoleDebugger::output($list);

        $this->assertCount(2, $list);
        $this->assertSame('home/projects/a/README.txt', $list[0]->path());
        $this->assertSame('home/projects/a/src', $list[1]->path());

        // ---------------------------------------------------------------- //
        // List directories inside "project a" deep

        $list = $this
            ->filesystem()
            ->listContents('home/projects/a', true)
            ->toArray();

        ConsoleDebugger::output($list);

        $this->assertCount(3, $list);
        $this->assertSame('home/projects/a/README.txt', $list[0]->path());
        $this->assertSame('home/projects/a/src', $list[1]->path());
        $this->assertSame('home/projects/a/src/book.txt', $list[2]->path());

        // ---------------------------------------------------------------- //
        // List all directories and files

        $list = $this
            ->filesystem()
            ->listContents('', true)
            ->toArray();

        ConsoleDebugger::output($list);

        $this->assertCount(15, $list);
    }
}
