<?php

namespace Aedart\Tests\Unit\Utils\Memory;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Memory;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * E0_SnapshotTest
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Unit\Utils\Memory
 */
#[Group(
    'utils',
    'utils-memory',
    'utils-memory-unit',
    'utils-memory-unit-e0',
    'utils-memory-unit-snapshot',
)]
class E0_SnapshotTest extends UnitTestCase
{
    /**
     * @return void
     */
    #[Test]
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
     * @return void
     */
    #[Test]
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
