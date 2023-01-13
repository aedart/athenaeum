<?php

namespace Aedart\Tests\Integration\Flysystem\Db\Adapters;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Flysystem\Db\FlysystemDbTestCase;
use League\Flysystem\FilesystemException;

/**
 * F0_ChecksumTest
 *
 * @group flysystem
 * @group flysystem-db
 * @group flysystem-db-f0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Flysystem\Db\Adapters
 */
class F0_ChecksumTest extends FlysystemDbTestCase
{
    /**
     * @test
     *
     * @return void
     *
     * @throws FilesystemException
     */
    public function canGetChecksumUsingCustomAlgo(): void
    {
        $path = 'home/books/october_falls.txt';
        $content = $this->getFaker()->sentence();

        // ----------------------------------------------------------------- //

        $fs = $this->filesystem();
        $fs->write($path, $content);

        // ----------------------------------------------------------------- //

        $algo = 'crc32';
        $expected = hash($algo, $content);
        $result = $fs->checksum($path, [ 'checksum_algo' => $algo ]);

        ConsoleDebugger::output([
            'expected' => $expected,
            'actual' => $result
        ]);

        $this->assertSame($expected, $result);
    }
}
