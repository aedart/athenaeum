<?php

namespace Aedart\Tests\Integration\Flysystem\Db\Adapters;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Flysystem\Db\FlysystemDbTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * E0_FilesAndDirectoryListing
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Flysystem\Db\Adapters
 */
#[Group(
    'flysystem',
    'flysystem-db',
    'flysystem-db-e0'
)]
class E0_FilesAndDirectoryListingTest extends FlysystemDbTestCase
{
    /**
     * @return void
     *
     * @throws \League\Flysystem\FilesystemException
     */
    #[Test]
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

    /**
     * @return void
     *
     * @throws \League\Flysystem\FilesystemException
     */
    #[Test]
    public function doesNotListContentsFromOtherDirectoriesWithSimilarPath(): void
    {
        // @see https://github.com/aedart/athenaeum/issues/193

        $directories = [
            'home/projects/2/src',
            'home/projects/22/src', // Notice that this path is similar to previous (starts with "home/projects/2...")
                                    // The adapter should NOT list files from this directory, unless requested!
            'home/projects/3/src',
            'home/utils',
        ];

        $this->createDirectories($directories);

        // ---------------------------------------------------------------- //

        $pathA = 'home/projects/2/README.txt';
        $pathB = 'home/projects/2/src/book.txt';

        $pathC = 'home/projects/22/people.txt';
        $pathD = 'home/projects/22/src/cookbook.txt';

        $pathE = 'home/projects/3/README.txt';
        $pathF = 'home/projects/3/src/book.txt';

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
            ->listContents('home/projects/2')
            ->toArray();

        ConsoleDebugger::output($list);

        $this->assertCount(2, $list);
        $this->assertSame('home/projects/2/README.txt', $list[0]->path());
        $this->assertSame('home/projects/2/src', $list[1]->path());

        // ---------------------------------------------------------------- //
        // List directories inside "project a" deep

        $list = $this
            ->filesystem()
            ->listContents('home/projects/2', true)
            ->toArray();

        ConsoleDebugger::output($list);

        $this->assertCount(3, $list);
        $this->assertSame('home/projects/2/README.txt', $list[0]->path());
        $this->assertSame('home/projects/2/src', $list[1]->path());
        $this->assertSame('home/projects/2/src/book.txt', $list[2]->path());

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
