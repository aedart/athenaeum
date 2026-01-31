<?php

namespace Aedart\Tests\Integration\Flysystem\Db\Adapters;

use Aedart\Contracts\Flysystem\Visibility;
use Aedart\Tests\TestCases\Flysystem\Db\FlysystemDbTestCase;
use Codeception\Attribute\Group;
use League\Flysystem\Config;
use League\Flysystem\InvalidVisibilityProvided;
use PHPUnit\Framework\Attributes\Test;

/**
 * D0_FileVisibilityTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Flysystem\Db\Adapters
 */
#[Group(
    'flysystem',
    'flysystem-db',
    'flysystem-db-d0'
)]
class D0_FileVisibilityTest extends FlysystemDbTestCase
{
    /**
     * @return void
     *
     * @throws \League\Flysystem\FilesystemException
     */
    #[Test]
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
     * @return void
     *
     * @throws \League\Flysystem\FilesystemException
     */
    #[Test]
    public function canSetVisibilityForFile(): void
    {
        $path = 'home/books/october_falls.txt';
        $content = $this->getFaker()->sentence();

        // ----------------------------------------------------------------- //

        $fs = $this->filesystem();
        $fs->write($path, $content, [
            Config::OPTION_VISIBILITY => 'public'
        ]);

        $fs->setVisibility($path, Visibility::PRIVATE->value);

        // ----------------------------------------------------------------- //

        $result = $fs->visibility($path);

        $this->assertSame(Visibility::PRIVATE->value, $result);
    }
}
