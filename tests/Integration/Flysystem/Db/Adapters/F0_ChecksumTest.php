<?php

namespace Aedart\Tests\Integration\Flysystem\Db\Adapters;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Flysystem\Db\FlysystemDbTestCase;
use Codeception\Attribute\Group;
use League\Flysystem\FilesystemException;
use PHPUnit\Framework\Attributes\Test;

/**
 * F0_ChecksumTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Flysystem\Db\Adapters
 */
#[Group(
    'flysystem',
    'flysystem-db',
    'flysystem-db-f0'
)]
class F0_ChecksumTest extends FlysystemDbTestCase
{
    /**
     * @return void
     *
     * @throws FilesystemException
     */
    #[Test]
    public function canGetChecksumUsingCustomAlgo(): void
    {
        $path = 'home/books/october_falls.txt';
        $content = $this->getFaker()->sentence();

        // ----------------------------------------------------------------- //

        $fs = $this->filesystem();
        $fs->write($path, $content);

        // ----------------------------------------------------------------- //

        $algo = 'xxh3';
        $expected = hash($algo, $content);
        $result = $fs->checksum($path, [ 'checksum_algo' => $algo ]);

        ConsoleDebugger::output([
            'expected' => $expected,
            'actual' => $result
        ]);

        $this->assertSame($expected, $result);
    }
}
