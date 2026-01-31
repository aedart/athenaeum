<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Streams\Stream;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * G0_OutputTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
#[Group(
    'streams',
    'stream-g0',
)]
class G0_OutputTest extends StreamTestCase
{
    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
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
