<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Streams\Stream;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Streams\StreamTestCase;

/**
 * G0_OutputTest
 *
 * @group streams
 * @group streams-g0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
class G0_OutputTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function canPassThrough()
    {
        $resource = fopen('php://memory', 'r+b');

        $data = $this->getFaker()->sentence(5);
        $stream = Stream::make($resource)
            ->put($data)
            ->positionToStart();

        ob_start();
        $stream->passThrough();
        $captured = ob_get_contents();
        ob_end_clean();

        ConsoleDebugger::output($captured);

        $this->assertSame($data, $captured);
    }
}
