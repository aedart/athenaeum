<?php

namespace Aedart\Tests\Integration\Streams\File;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Streams\FileStream;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * J0_SyncTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams\File
 */
#[Group(
    'streams',
    'stream-file',
    'stream-file-e1',
)]
class E1_SyncTest extends StreamTestCase
{
    /**
     * Name of test file
     *
     * @var string
     */
    protected string $syncFile = 'sync_file.txt';

    /*****************************************************************
     * Setup
     ****************************************************************/

    public function _before()
    {
        parent::_before();

        $path = $this->outputFilePath($this->syncFile);

        $fs = $this->getFile();
        $fs->ensureDirectoryExists(dirname($path));
        if ($fs->exists($path)) {
            $fs->delete($path);
        }

        touch($path);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @return void
     * @throws StreamException
     */
    #[Test]
    public function canSyncChangesToFile(): void
    {
        $faker = $this->getFaker();
        $path = $this->outputFilePath($this->syncFile);

        $a = $faker->unique()->sentence();
        $writeStream = FileStream::open($path, 'w');

        // Add data and sync to file...
        $writeStream
            ->put($a)
            ->sync();
        ConsoleDebugger::output('Write (a): ' . $a);

        // NOTE: changes are not synced for this operation...
        $b = $faker->unique()->sentence();
        $writeStream
            ->put($b);
        ConsoleDebugger::output('Write (b): ' . $b);

        // Use a read stream to obtain written data...
        $readStream = FileStream::open($path, 'r');
        $result = $readStream->getContents();
        ConsoleDebugger::output('Read (only a expected): ' . $result);

        // Only the first write should be synced to the file
        $this->assertSame($a, $result);
    }
}
