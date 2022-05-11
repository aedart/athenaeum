<?php

namespace Aedart\Tests\Integration\Flysystem\Db\Adapters;

use Aedart\Flysystem\Db\Adapters\DatabaseAdapter;
use Aedart\Tests\TestCases\Flysystem\Db\FlysystemDbTestCase;

/**
 * A0_DatabaseAdapterTest
 *
 * @group flysystem
 * @group flysystem-db
 * @group flysystem-db-a0
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Flysystem\Db\Adapters
 */
class A0_DatabaseAdapterTest extends FlysystemDbTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function canObtainAdapterInstance(): void
    {
        $adapter = new DatabaseAdapter('files', 'file_contents', null);

        // If no failure, means that nothing wrong inside constructor...
        $this->assertNotNull($adapter);
    }

    /**
     * @test
     *
     * @return void
     */
    public function canObtainFilesystemWithDbAdapter(): void
    {
        $fs = $this->filesystem();

        $this->assertNotNull($fs);
    }
}