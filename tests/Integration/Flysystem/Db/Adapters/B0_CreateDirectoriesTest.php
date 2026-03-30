<?php

namespace Aedart\Tests\Integration\Flysystem\Db\Adapters;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Flysystem\Db\FlysystemDbTestCase;
use Codeception\Attribute\Group;
use League\Flysystem\FilesystemException;
use PHPUnit\Framework\Attributes\Test;

/**
 * B0_DirectoriesTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Flysystem\Db\Adapters
 */
#[Group(
    'flysystem',
    'flysystem-db',
    'flysystem-db-b0'
)]
class B0_CreateDirectoriesTest extends FlysystemDbTestCase
{
    /**
     * @return void
     *
     * @throws FilesystemException
     */
    #[Test]
    public function canCreateDirectory()
    {
        $path = 'home';
        $fs = $this->filesystem();

        $fs->createDirectory($path);

        // ----------------------------------------------------------- //

        $directories = $this->fetchAllDirectories();

        $this->assertCount(1, $directories);
        $this->assertSame($path, $directories[0]->path, 'Invalid path for directory');
    }

    /**
     * @return void
     *
     * @throws FilesystemException
     */
    #[Test]
    public function canCreateDirectoryRecursively(): void
    {
        $path = 'home/user/project';
        $fs = $this->filesystem();

        $fs->createDirectory($path);

        // ----------------------------------------------------------- //

        $directories = $this->fetchAllDirectories();

        ConsoleDebugger::output($directories->toArray());

        $this->assertCount(3, $directories);
        $this->assertSame('home', $directories[0]->path, 'Invalid level 0 path');
        $this->assertSame('home/user', $directories[1]->path, 'Invalid level 1 path');
        $this->assertSame('home/user/project', $directories[2]->path, 'Invalid level 2 path');
    }

    /**
     * @return void
     *
     * @throws FilesystemException
     */
    #[Test]
    public function automaticallyPrefixesWhenCreatingDirectory(): void
    {
        $prefix = 'root';
        $path = 'home';
        $fs = $this->filesystem($prefix);

        $fs->createDirectory($path);

        // ----------------------------------------------------------- //

        $directories = $this->fetchAllDirectories();

        ConsoleDebugger::output($directories->toArray());

        $this->assertCount(2, $directories);
        $this->assertSame('root', $directories[0]->path, 'Invalid level 0 path');
        $this->assertSame('root/home', $directories[1]->path, 'Invalid level 1 path');
    }

    /**
     * @return void
     *
     * @throws FilesystemException
     */
    #[Test]
    public function updatesDirectoryIfAlreadyExists(): void
    {
        $pathA = 'project_a';
        $pathB = 'project_a/src';
        $fs = $this->filesystem();

        $fs->createDirectory($pathA);

        // Here, the "project_a" is already created. Thus, if the method
        // fails, it means that recursive create logic is incorrect.
        $fs->createDirectory($pathB);

        // ----------------------------------------------------------- //

        $directories = $this->fetchAllDirectories();

        ConsoleDebugger::output($directories->toArray());

        $this->assertCount(2, $directories);
        $this->assertSame('project_a', $directories[0]->path, 'Invalid level 0 path');
        $this->assertSame('project_a/src', $directories[1]->path, 'Invalid level 1 path');
    }
}
