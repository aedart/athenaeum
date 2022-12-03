<?php

namespace Aedart\Tests\Integration\Flysystem\Db\Storage;

use Aedart\Flysystem\Db\Adapters\DatabaseAdapter;
use Aedart\Tests\TestCases\Flysystem\Db\FlysystemDbTestCase;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

/**
 * StorageDiskTest
 *
 * @group flysystem
 * @group flysystem-db
 * @group flysystem-db-storage-disk
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Flysystem\Db\Storage
 */
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
            'connection' => 'testing',
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
     * @test
     *
     * @return void
     */
    public function canObtainDisk(): void
    {
        $disk = $this->disk();
        $this->assertNotNull($disk);

        $adapter = $disk
            ->getAdapter();

        $this->assertInstanceOf(DatabaseAdapter::class, $adapter);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
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