<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Streams\Stream;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Streams\StreamTestCase;

/**
 * D3_ScanTest
 *
 * @group streams
 * @group streams-d3
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
class D3_ScanTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
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
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
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
