<?php

namespace Aedart\Tests\Integration\Flysystem\Db\Storage;

use Aedart\Flysystem\Db\Adapters\DatabaseAdapter;
use Aedart\Tests\TestCases\Flysystem\Db\FlysystemDbTestCase;
use Codeception\Attribute\Group;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;

/**
 * StorageDiskTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Flysystem\Db\Storage
 */
#[Group(
    'flysystem',
    'flysystem-db',
    'flysystem-db-storage-disk'
)]
class StorageDiskTest extends FlysystemDbTestCase
{
    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * @inheritdoc
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        // Add database storage disk to configuration.
        $app['config']->set('filesystems.disks.database', [
            'driver' => 'database',
            'connection' => $app['config']->get('database.default', 'testing'),
            'files_table' => 'files',
            'contents_table' => 'file_contents',
            'hash_algo' => 'sha256',
            'path_prefix' => '',
        ]);
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Obtain the database storage disk
     *
     * @return Filesystem
     */
    public function disk(): Filesystem
    {
        return Storage::disk('database');
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @return void
     */
    #[Test]
    public function canObtainDisk(): void
    {
        $disk = $this->disk();
        $this->assertNotNull($disk);

        $adapter = $disk
            ->getAdapter();

        $this->assertInstanceOf(DatabaseAdapter::class, $adapter);
    }

    /**
     * @return void
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    #[Test]
    public function canWriteAndReadFile(): void
    {
        $disk = $this->disk();

        $path = 'home/books/cooking.txt';
        $content = $this->getFaker()->sentence();

        $hasWritten = $disk->put($path, $content);
        $read = $disk->get($path);

        $this->assertTrue($hasWritten, 'failed to write file');
        $this->assertSame($content, $read, 'invalid file content');
    }
}
