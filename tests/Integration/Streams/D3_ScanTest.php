<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Streams\Stream;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * D3_ScanTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
#[Group(
    'streams',
    'stream-d3',
)]
class D3_ScanTest extends StreamTestCase
{
    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canScanAccordingToFormat()
    {
        $content = "aa-\nbb-\ncc-\n";
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $content);

        $stream = Stream::make($resource)
            ->positionToStart();

        $buffer = '';
        while ($scanned = $stream->scan('%s-')) {
            $buffer .= $scanned[0];
        }

        ConsoleDebugger::output($buffer);

        $this->assertSame('aa-bb-cc-', $buffer);
    }

    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canReadAllUsingFormat()
    {
        $content = "aa||\nbb||\ncc||\n";
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $content);

        $stream = Stream::make($resource)
            ->positionToStart();

        $buffer = '';
        $iterator = $stream->readAllUsingFormat('%s||');
        foreach ($iterator as $scanned) {
            ConsoleDebugger::output($scanned);

            $buffer .= $scanned[0];
        }

        $this->assertSame('aa||bb||cc||', $buffer);
    }
}
