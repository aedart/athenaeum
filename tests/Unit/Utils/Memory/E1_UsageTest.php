<?php

namespace Aedart\Tests\Unit\Utils\Memory;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Memory;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * E1_UsageTest
 *
 * @group utils
 * @group utils-memory
 * @group utils-memory-unit
 * @group utils-memory-unit-e1
 * @group utils-memory-usage
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Unit\Utils\Memory
 */
#[Group(
    'utils',
    'utils-memory',
    'utils-memory-unit',
    'utils-memory-unit-e1',
    'utils-memory-unit-usage',
)]
class E1_UsageTest extends UnitTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canObtainMemoryUsage(): void
    {
        $bytes = 1024 * 1024 * 8;
        $str = str_repeat('a', $bytes);

        $usage = Memory::usage();

        ConsoleDebugger::output([
            'usage' => $usage->bytes(),
        ]);

        unset($str);

        $this->assertGreaterThan($bytes, $usage->bytes());
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canObtainMemoryRealUsage(): void
    {
        $bytes = 1024 * 1024 * 8;
        $str = str_repeat('a', $bytes);

        $usage = Memory::usage();
        $realUsage = Memory::usage(true);

        ConsoleDebugger::output([
            'usage' => $usage->bytes(),
            'real' => $realUsage->bytes(),
        ]);

        unset($str);

        $this->assertGreaterThan($usage->bytes(), $realUsage->bytes());
    }
}
