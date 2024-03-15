<?php

namespace Aedart\Tests\Unit\Utils\Memory;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Memory;

/**
 * E0_SnapshotTest
 *
 * @group utils
 * @group utils-memory
 * @group utils-memory-unit
 * @group utils-memory-unit-e0
 * @group utils-memory-snapshot
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Unit\Utils\Memory
 */
class E0_SnapshotTest extends UnitTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function canObtainSnapshotWithoutReset(): void
    {
        $str = str_repeat('a', 1024 * 1024 * 4);
        $snapshotBefore = Memory::snapshot(false);

        unset($str);
        $snapshotAfter = Memory::snapshot(false);

        ConsoleDebugger::output([
            'before' => $snapshotBefore->bytes(),
            'after' => $snapshotAfter->bytes()
        ]);

        $this->assertGreaterThan(0, $snapshotBefore->bytes(), 'before');
        $this->assertGreaterThan(0, $snapshotAfter->bytes(), 'after');

        // Can be unreliable, when multiple tests are executed...
        //        $this->assertGreaterThanOrEqual($snapshotBefore->bytes(), $snapshotAfter->bytes());
    }

    /**
     * @test
     *
     * @return void
     */
    public function canObtainSnapshotWithReset(): void
    {
        $str = str_repeat('a', 1024 * 1024 * 4);
        $snapshotBefore = Memory::snapshot();

        unset($str);
        $snapshotAfter = Memory::snapshot();

        ConsoleDebugger::output([
            'before' => $snapshotBefore->bytes(),
            'after' => $snapshotAfter->bytes()
        ]);

        $this->assertGreaterThan(0, $snapshotBefore->bytes(), 'before');
        $this->assertGreaterThan(0, $snapshotAfter->bytes(), 'after');

        // Can be unreliable, when multiple tests are executed...
        //        $this->assertLessThanOrEqual($snapshotBefore->bytes(), $snapshotAfter->bytes());
    }
}
