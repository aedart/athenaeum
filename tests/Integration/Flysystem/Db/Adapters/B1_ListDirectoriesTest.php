<?php

namespace Aedart\Tests\Integration\Flysystem\Db\Adapters;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Flysystem\Db\FlysystemDbTestCase;
use Codeception\Attribute\Group;
use League\Flysystem\FilesystemException;
use PHPUnit\Framework\Attributes\Test;

/**
 * B1_ListDirectoriesTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Flysystem\Db\Adapters
 */
#[Group(
    'flysystem',
    'flysystem-db',
    'flysystem-db-b1'
)]
class B1_ListDirectoriesTest extends FlysystemDbTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * @return void
     *
     * @throws FilesystemException
     */
    #[Test]
    public function canListRootLevelDirectories(): void
    {
        $directories = [
            'home/projects/a/src',
            'home/projects/b/src',
            'home/projects/c/src',
            'home/utils',
        ];

        $this->createDirectories($directories);

        // ---------------------------------------------------------------- //
        // List directories inside "home"

        $list = $this
            ->filesystem()
            ->listContents('')
            ->toArray();

        ConsoleDebugger::output($list);

        $this->assertCount(1, $list);
        $this->assertSame('home', $list[0]->path());
    }

    /**
     * @return void
     *
     * @throws FilesystemException
     */
    #[Test]
    public function canListDirectoriesForSingleLevel(): void
    {
        $directories = [
            'home/projects/a/src',
            'home/projects/b/src',
            'home/projects/c/src',
            'home/utils',
        ];

        $this->createDirectories($directories);

        // ---------------------------------------------------------------- //
        // List directories inside "home"

        $list = $this
            ->filesystem()
            ->listContents('home')
            ->toArray();

        ConsoleDebugger::output($list);

        $this->assertCount(2, $list);
        $this->assertSame('home/projects', $list[0]->path());
        $this->assertSame('home/utils', $list[1]->path());
    }

    /**
     * @return void
     *
     * @throws FilesystemException
     */
    #[Test]
    public function canListDirectoriesDeep(): void
    {
        $directories = [
            'home/projects/a/src',
            'home/projects/b/src',
            'home/projects/c/src',
            'home/utils',
        ];

        $this->createDirectories($directories);

        // ---------------------------------------------------------------- //
        // List directories inside "projects" deep

        $list = $this
            ->filesystem()
            ->listContents('home/projects', true)
            ->toArray();

        ConsoleDebugger::output($list);

        $this->assertCount(6, $list);
        $this->assertSame('home/projects/a', $list[0]->path());
        $this->assertSame('home/projects/a/src', $list[1]->path());

        $this->assertSame('home/projects/b', $list[2]->path());
        $this->assertSame('home/projects/b/src', $list[3]->path());

        $this->assertSame('home/projects/c', $list[4]->path());
        $this->assertSame('home/projects/c/src', $list[5]->path());
    }
}
