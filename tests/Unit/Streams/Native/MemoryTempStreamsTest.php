<?php

namespace Aedart\Tests\Unit\Streams\Native;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * MemoryStreamTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Streams
 */
#[Group(
    'streams',
    'streams-memory',
    'streams-temp'
)]
class MemoryTempStreamsTest extends UnitTestCase
{
    /**
     * @return void
     */
    #[Test]
    public function memoryStreamsAreNotShared()
    {
        $a = fopen('php://memory', 'w+');
        $b = fopen('php://memory', 'w+');

        // ------------------------------------------------------------------- //

        $data = 'You have to wrestle, and experience living by your remaining.';
        fwrite($a, $data);

        // ------------------------------------------------------------------- //

        rewind($a);
        rewind($b);

        // Get content of both streams - hopefully they are unique...
        $resultA = stream_get_contents($a);
        $resultB = stream_get_contents($b);

        ConsoleDebugger::output([
            'stream_a' => $resultA,
            'stream_b' => $resultB
        ]);

        $this->assertNotSame($resultA, $resultB, 'Memory streams appear to be shared in the same PHP process!');
        $this->assertSame($data, $resultA, 'Invalid content in stream a');
        $this->assertEmpty($resultB, 'Stream b should had been empty');

        fclose($a);
        fclose($b);
    }

    /**
     * @return void
     */
    #[Test]
    public function tempStreamsAreNotShared()
    {
        $a = fopen('php://temp', 'w+');
        $b = fopen('php://temp', 'w+');

        // ------------------------------------------------------------------- //

        $data = 'After chopping the eggs, brush apple, pickles and lemon juice with it in a sauté pan.';
        fwrite($a, $data);

        // ------------------------------------------------------------------- //

        rewind($a);
        rewind($b);

        // Get content of both streams - hopefully they are unique...
        $resultA = stream_get_contents($a);
        $resultB = stream_get_contents($b);

        ConsoleDebugger::output([
            'stream_a' => $resultA,
            'stream_b' => $resultB
        ]);

        $this->assertNotSame($resultA, $resultB, 'Temp streams appear to be shared in the same PHP process!');
        $this->assertSame($data, $resultA, 'Invalid content in stream a');
        $this->assertEmpty($resultB, 'Stream b should had been empty');

        fclose($a);
        fclose($b);
    }
}
