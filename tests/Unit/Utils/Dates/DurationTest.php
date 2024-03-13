<?php

namespace Aedart\Tests\Unit\Utils\Dates;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Dates\Duration;
use DateInterval;
use DateTime;

/**
 * DurationTest
 *
 * @group utils
 * @group date
 * @group duration
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Dates
 */
class DurationTest extends UnitTestCase
{
    /**
     * @test
     */
    public function canInstantiate()
    {
        $duration = new Duration(42);

        $this->assertSame("42", $duration->format("%S"));
    }

    /**
     * @test
     *
     * @return void
     */
    public function canInstantiateWithoutArguments(): void
    {
        $duration = Duration::now();

        $this->assertGreaterThan(0, $duration->asMicroSeconds());
    }

    /**
     * @test
     */
    public function longDuration()
    {
        $seconds = 10 * 365 * 24 * 3600; // 10 years of seconds
        $duration = Duration::fromSeconds($seconds);

        $this->assertSame($seconds, $duration->asSeconds());
        $this->assertSame(floatval($seconds), $duration->asFloatSeconds());
    }

    /**
     * @test
     */
    public function instantiateFromDateInterval()
    {
        $duration = Duration::from(new DateInterval('P10Y7DT4H5M34S'));

        $this->assertSame('10-00-07 04:05:34', $duration->format('%Y-%M-%D %H:%I:%S'));
    }

    /**
     * @test
     */
    public function instantiateFromDateTime()
    {
        $duration = Duration::from(new DateTime('@' . (42 * 60)));

        $this->assertSame(42 * 60, $duration->asSeconds());
    }

    /**
     * @test
     */
    public function instantiateFromString()
    {
        $duration = Duration::fromString('@' . (42 * 60));

        $this->assertSame(42 * 60, $duration->asSeconds());
    }

    /**
     * @test
     */
    public function instantiateFromDifference()
    {
        $now = '2020-09-23';
        $then = new DateTime("$now - 5 hours - 6 minutes");
        $when = new DateTime("$now + 42 seconds + 23456 microseconds");

        $duration = Duration::fromDifference($then, $when);

        $this->assertSame((5 * 3600) + (6 * 60) + 42, $duration->asSeconds());
        $this->assertSame('00-00-00 05:06:42.023456', $duration->format('%r%Y-%M-%D %H:%I:%S.%F'));
    }

    /**
     * @test
     */
    public function instantiateFromInvertedDifference()
    {
        $now = '2020-09-23';
        $then = new DateTime("$now - 5 hours - 6 minutes");
        $when = new DateTime("$now + 42 seconds + 23456 microseconds");

        $duration = Duration::fromDifference($when, $then);

        $this->assertSame(-(5 * 3600) - (6 * 60) - 42, $duration->asSeconds());
        $this->assertSame('-00-00-00 05:06:42.023456', $duration->format('%r%Y-%M-%D %H:%I:%S.%F'));
    }

    /**
     * @test
     */
    public function instantiateFromStringHoursMinutes()
    {
        $a = '00:30';
        $durationA = Duration::fromStringHoursMinutes($a);
        $this->assertSame(1800, $durationA->asSeconds());

        $b = '1:25';
        $durationB = Duration::fromStringHoursMinutes($b);
        $this->assertSame(5100, $durationB->asSeconds());

        $c = '-01:25';
        $durationC = Duration::fromStringHoursMinutes($c);
        $this->assertSame(-5100, $durationC->asSeconds());
    }

    /**
     * @test
     */
    public function addInterval()
    {
        $duration = Duration::fromString('@40');
        $duration->add(Duration::fromString('@2'));

        $this->assertSame(42, $duration->asSeconds());
    }

    /**
     * @test
     */
    public function subtractInterval()
    {
        $duration = Duration::fromString('@44');
        $duration->subtract(Duration::fromString('@2'));

        $this->assertSame(42, $duration->asSeconds());
    }

    /**
     * @test
     */
    public function measureInterval()
    {
        $duration = new Duration();
        $duration->start();
        sleep(1);
        $duration->stop();

        $this->assertSame(1, $duration->asSeconds());
    }

    /**
     * @test
     */
    public function requestedTestCase()
    {
        $duration = Duration::from(52200);

        $this->assertSame('14:30', $duration->format('%H:%i')); // Should out 14:30 (hours and minutes)
        //        $this->assertSame(0.6042, $duration->format('%D')); // Should output ~0.6042 days
        $this->assertSame(870, $duration->asMinutes()); // 870 minutes
    }

    /**
     * @test
     */
    public function toMinutesSeconds()
    {
        $duration = Duration::from(65);

        $this->assertSame('01:05', $duration->toMinutesSeconds());
    }

    /**
     * @test
     */
    public function canShowAbove60Minutes()
    {
        $duration = Duration::from(3600);
        ConsoleDebugger::output([ '3600 seconds' => $duration->toMinutesSeconds() ]);
        $this->assertSame('60:00', $duration->toMinutesSeconds());

        $duration = Duration::from(52200);
        ConsoleDebugger::output([ '52200 seconds' => $duration->toMinutesSeconds() ]);
        $this->assertSame('870:00', $duration->toMinutesSeconds());
    }

    /**
     * @test
     */
    public function toHoursMinutes()
    {
        $duration = Duration::from(52200);

        $this->assertSame('14:30', $duration->toHoursMinutes()); // Should out 14:30 (hours and minutes)
        $this->assertSame('14 hours 30 minutes', $duration->toHoursMinutes(true));
    }

    /**
     * @test
     */
    public function canShowAbove24Hours()
    {
        $duration = Duration::from(86400);
        ConsoleDebugger::output([ '86400 seconds' => $duration->toHoursMinutes() ]);
        $this->assertSame('24:00', $duration->toHoursMinutes());

        $duration = Duration::from(111600);
        ConsoleDebugger::output([ '111600 seconds' => $duration->toHoursMinutes() ]);
        $this->assertSame('31:00', $duration->toHoursMinutes());
    }

    /**
     * @test
     */
    public function toDaysHoursMinutes()
    {
        $duration = Duration::from(225000);

        $this->assertSame(225000, $duration->asSeconds());
        $this->assertSame('2-14:30', $duration->toDaysHoursMinutes()); // Should out 14:30 (hours and minutes)
        $this->assertSame('2 days 14 hours 30 minutes', $duration->toDaysHoursMinutes(true));
    }

    /**
     * @test
     */
    public function toSignedHoursMinutes()
    {
        $duration = Duration::from(-52200);

        $this->assertSame(-52200, $duration->asSeconds());

        $this->assertSame('-14:30', $duration->toHoursMinutes()); // Should out 14:30 (hours and minutes)
        $this->assertSame('-14 hours 30 minutes', $duration->toHoursMinutes(true));

        $this->assertSame('-870:00', $duration->toMinutesSeconds());
        $this->assertSame('-870 minutes 00 seconds', $duration->toMinutesSeconds(true));

        // ------------------------------------------------ //

        $duration = Duration::from(-2700); // -45 minutes
        $this->assertSame(-2700, $duration->asSeconds());
        $this->assertSame('-00:45', $duration->toHoursMinutes());

        $duration = Duration::from(-5); // -5 seconds
        $this->assertSame(-5, $duration->asSeconds());
        $this->assertSame('-00:05', $duration->toMinutesSeconds());
    }

    /**
     * @test
     */
    public function testToString()
    {
        $duration = Duration::from(225000);
        $this->assertSame('2-14:30', $duration->toString());
        $this->assertSame('2 days 14 hours 30 minutes', (string)$duration);

        $duration->subtract(Duration::from(200000));
        $this->assertSame('06:56', $duration->toString());
        $this->assertSame('6 hours 56 minutes', (string)$duration);

        $duration->subtract(Duration::from(24641));
        $this->assertSame('05:59', $duration->toString());
        $this->assertSame('05 minutes 59 seconds', (string)$duration);
    }
}
