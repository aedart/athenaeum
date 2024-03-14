<?php

namespace Aedart\Tests\Unit\Utils;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Memory;
use InvalidArgumentException;

/**
 * MemoryTest
 *
 * @group utils
 * @group utils-memory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils
 */
class MemoryTest extends UnitTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function canFormat()
    {
        // NOTE: See tests in Aedart\Tests\Unit\Utils\Memory, rather than the tests in here.
        // Here, the tests act as "tinkering"...

        $a = Memory::format(800); // bytes
        $b = Memory::format(1024); // kilobytes
        $c = Memory::format(5.84 * pow(1024, 2)); // megabytes
        $d = Memory::format(2.3 * pow(1024, 3)); // gigabytes
        $e = Memory::format(1.4 * pow(1024, 4)); // terabytes
        $f = Memory::format(9.328 * pow(1024, 5)); // petabytes
        $g = Memory::format(6.297 * pow(1024, 6)); // exabytes
        //$h = Memory::format(1.251 * pow(1024, 7)); // zettabytes
        //$i = Memory::format(3.87 * pow(1024, 8)); // yottabytes

        //$x = Memory::format(2.22 * pow(1024, 9)); // ???
        $y = Memory::format(0); // bytes

        // Note: here the legacy terms are used...
        ConsoleDebugger::output([
            'bytes' => $a,
            'kilobytes' => $b,
            'megabytes' => $c,
            'gigabytes' => $d,
            'terabytes' => $e,
            'petabytes' => $f,
            'exabytes' => $g,
            //'zettabytes' => $h,
            //'yottabytes' => $i,

            //'x' => $x,
            'y' => $y,
        ]);

        $this->assertNotEmpty($a, 'a empty');
        $this->assertNotEmpty($b, 'b empty');
        $this->assertNotEmpty($c, 'c empty');
        $this->assertNotEmpty($d, 'd empty');
        $this->assertNotEmpty($e, 'e empty');
        $this->assertNotEmpty($f, 'f empty');
        $this->assertNotEmpty($g, 'g empty');
        //        $this->assertNotEmpty($h, 'h empty');
        //        $this->assertNotEmpty($i, 'i empty');
        //
        //        $this->assertNotEmpty($x, 'x empty');
        $this->assertNotEmpty($y, 'y empty');
    }

    /**
     * @test
     *
     * @return void
     */
    public function failsFormattingBytesWhenNegativeValueGiven()
    {
        $this->expectException(InvalidArgumentException::class);

        Memory::format(-1);
    }

    /**
     * @test
     *
     * @return void
     */
    public function failsFormattingBytesWhenNoUnitsProvided()
    {
        $this->expectException(InvalidArgumentException::class);

        Memory::format(800, 0, false, []);
    }
}
