<?php

namespace Aedart\Tests\Unit\ETags\Ranges;

use Aedart\Contracts\ETags\Preconditions\Ranges\RangeSet as RangeSetInterface;
use Aedart\ETags\Preconditions\Ranges\RangeSet;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Memory\Unit;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * RangeSetTest
 *
 * @group etags
 * @group ranges
 * @group range-set
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\ETags\Ranges
 */
#[Group(
    'etags',
    'ranges',
    'range-set',
)]
class RangeSetTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new range-set instance
     *
     * @param  string  $unit
     * @param  string  $range
     * @param  int  $start
     * @param  int  $end
     * @param  mixed  $totalSize
     *
     * @return RangeSetInterface
     */
    public function makeRangeSet(
        string $unit,
        string $range,
        int $start,
        int $end,
        mixed $totalSize
    ): RangeSetInterface {
        return new RangeSet(
            unit: $unit,
            range: $range,
            start: $start,
            end: $end,
            totalSize: $totalSize
        );
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canCreateInstance(): void
    {
        $faker = $this->getFaker();

        $unit = $faker->randomElement([ 'bytes', 'kilobytes', 'megabytes' ]);
        $start = $faker->randomDigitNotNull();
        $end = $start + $faker->randomDigitNotNull();
        $totalSize = $faker->randomNumber(3, true);
        $range = "{$start}-{$end}";

        // --------------------------------------------------------------------------- //

        $rangeSet = $this->makeRangeSet(
            unit: $unit,
            range: $range,
            start: $start,
            end: $end,
            totalSize: $totalSize
        );

        ConsoleDebugger::output($rangeSet);

        // --------------------------------------------------------------------------- //

        $this->assertSame($unit, $rangeSet->unit(), 'invalid unit');
        $this->assertSame($start, $rangeSet->getStart(), 'invalid start');
        $this->assertSame($end, $rangeSet->getEnd(), 'invalid end');
        $this->assertSame($range, $rangeSet->getRange(), 'invalid range');
        $this->assertSame($totalSize, $rangeSet->getTotalSize(), 'invalid total size');

        $this->assertNotEmpty($rangeSet->getLength(), 'No length was computed!');
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canObtainBytes(): void
    {
        $faker = $this->getFaker();

        $unit = 'kilobytes';
        $start = $faker->randomDigitNotNull();
        $end = $start + $faker->randomDigitNotNull();
        $totalSize = $faker->randomNumber(3, true);
        $range = "{$start}-{$end}";

        // --------------------------------------------------------------------------- //

        $rangeSet = $this->makeRangeSet(
            unit: $unit,
            range: $range,
            start: $start,
            end: $end,
            totalSize: $totalSize
        );

        ConsoleDebugger::output($rangeSet);

        // --------------------------------------------------------------------------- //

        ConsoleDebugger::output('In bytes:');
        $results = [
            'start' => $rangeSet->getStartBytes(),
            'end' => $rangeSet->getEndBytes(),
            'total' => $rangeSet->getTotalSizeInBytes(),
            'length' => $rangeSet->getLengthInBytes()
        ];

        ConsoleDebugger::output($results);

        $this->assertSame(Unit::fromKilobyte($start)->bytes(), $results['start'], 'invalid start in bytes');
        $this->assertSame(Unit::fromKilobyte($end)->bytes(), $results['end'], 'invalid end in bytes');
        $this->assertSame(Unit::fromKilobyte($totalSize)->bytes(), $results['total'], 'invalid total size in bytes');

        $this->assertSame(Unit::fromKilobyte($rangeSet->getLength())->bytes(), $results['length'], 'invalid length in bytes');
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canObtainContentRangeValue(): void
    {
        $faker = $this->getFaker();

        $unit = $faker->randomElement([ 'bytes', 'kilobytes', 'megabytes' ]);
        $start = $faker->randomDigitNotNull();
        $end = $start + $faker->randomDigitNotNull();
        $totalSize = $faker->randomNumber(3, true);
        $range = "{$start}-{$end}";

        // --------------------------------------------------------------------------- //

        $rangeSet = $this->makeRangeSet(
            unit: $unit,
            range: $range,
            start: $start,
            end: $end,
            totalSize: $totalSize
        );

        // --------------------------------------------------------------------------- //

        $result = (string) $rangeSet;

        ConsoleDebugger::output($result);

        $this->assertNotEmpty($result);
    }
}
