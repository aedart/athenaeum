<?php

namespace Aedart\Tests\Integration\Flysystem\Db\Adapters;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Flysystem\Db\FlysystemDbTestCase;
use Codeception\Attribute\Group;
use League\Flysystem\FilesystemException;
use PHPUnit\Framework\Attributes\Test;

/**
 * B2_DeleteDirectoryTest
 *
 * @group flysystem
 * @group flysystem-db
 * @group flysystem-db-b2
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Flysystem\Db\Adapters
 */
#[Group(
    'flysystem',
    'flysystem-db',
    'flysystem-db-b2'
)]
class B2_DeleteDirectoryTest extends FlysystemDbTestCase
{
    /**
     * @test
     *
     * @return void
     *
     * @throws FilesystemException
     */
    #[Test]
    public function canDeleteSingleDirectory(): void
    {
        $directories = [
            'projects',
        ];

        $this->createDirectories($directories);

        // ---------------------------------------------------------------- //

        $fs = $this->filesystem();
        $fs->deleteDirectory('projects');

        // ---------------------------------------------------------------- //

        $list = $fs
            ->listContents('')
            ->toArray();

        ConsoleDebugger::output($list);

        $this->assertempty($list);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws FilesystemException
     */
    #[Test]
    public function deletesNestedDirectories(): void
    {
        $directories = [
            'home/projects/a/src',
            'home/projects/b/src',
            'home/projects/c/src',
            'home/utils',
        ];

        $this->createDirectories($directories);

        // ---------------------------------------------------------------- //

        $fs = $this->filesystem();
        $fs->deleteDirectory('home/projects');

        // ---------------------------------------------------------------- //

        $list = $fs
            ->listContents('', true)
            ->toArray();

        ConsoleDebugger::output($list);

        $this->assertCount(2, $list);
        $this->assertSame('home', $list[0]->path());
        $this->assertSame('home/utils', $list[1]->path());
    }
}
