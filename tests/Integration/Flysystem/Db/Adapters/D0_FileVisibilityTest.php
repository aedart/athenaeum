<?php

namespace Aedart\Tests\Integration\Flysystem\Db\Adapters;

use Aedart\Contracts\Flysystem\Visibility;
use Aedart\Tests\TestCases\Flysystem\Db\FlysystemDbTestCase;
use League\Flysystem\InvalidVisibilityProvided;

/**
 * D0_FileVisibilityTest
 *
 * @group flysystem
 * @group flysystem-db
 * @group flysystem-db-d0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Flysystem\Db\Adapters
 */
class D0_FileVisibilityTest extends FlysystemDbTestCase
{
    /**
     * @test
     *
     * @return void
     *
     * @throws \League\Flysystem\FilesystemException
     */
    public function failsSettingVisibilityWhenValueNotSupported(): void
    {
        $this->expectException(InvalidVisibilityProvided::class);

        $path = 'home/books/october_falls.txt';
        $content = $this->getFaker()->sentence();

        // ----------------------------------------------------------------- //

        $fs = $this->filesystem();
        $fs->write($path, $content);

        $fs->setVisibility($path, 'custom-invalid-visibility');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws \League\Flysystem\FilesystemException
     */
    public function canSetVisibilityForFile(): void
    {
        $path = 'home/books/october_falls.txt';
        $content = $this->getFaker()->sentence();

        // ----------------------------------------------------------------- //

        $fs = $this->filesystem();
        $fs->write($path, $content);

        $fs->setVisibility($path, Visibility::PRIVATE->value);

        // ----------------------------------------------------------------- //

        $result = $fs->visibility($path);

        $this->assertSame(Visibility::PRIVATE->value, $result);
    }
}
