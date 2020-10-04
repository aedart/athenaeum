<?php

namespace Aedart\Tests\Unit\Utils\Dates;

use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Dates\Duration;

/**
 * DurationTest
 *
 * @group utils
 * @group date
 * @group duration
 *
 * Example: codecept run Unit Utils
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

        $this->assertSame($duration->format("%S"), "42");
    }

    /**
     * @test
     */
    public function longDuration()
    {
        $seconds = 10 * 365 * 24 * 3600; // 10 years of seconds
        $duration = Duration::fromSeconds($seconds);

        $this->assertSame($duration->asSeconds(), $seconds);
        $this->assertSame($duration->asFloatSeconds(), floatval($seconds));
    }

    /**
     * @test
     */
    public function instantiateFromDateInterval()
    {
        $duration = Duration::from(new \DateInterval('P10Y7DT4H5M34S'));

        $this->assertSame($duration->format('%Y-%M-%D %H:%I:%S'), '10-00-07 04:05:34');
    }

    /**
     * @test
     */
    public function instantiateFromDateTime()
    {
        $duration = Duration::from(new \DateTime('@' . (42 * 60)));

        $this->assertSame($duration->asSeconds(), 42 * 60);
    }

    /**
     * @test
     */
    public function instantiateFromString()
    {
        $duration = Duration::fromString('@' . (42 * 60));

        $this->assertSame($duration->asSeconds(), 42 * 60);
    }

    /**
     * @test
     */
    public function instantiateFromDifference()
    {
        $now = '2020-09-23';
        $then = new \DateTime("$now - 5 hours - 6 minutes");
        $when = new \DateTime("$now + 42 seconds + 23456 microseconds");

        $duration = Duration::fromDifference($then, $when);

        $this->assertSame($duration->asSeconds(), (5 * 3600) + (6 * 60) + 42);
        $this->assertSame($duration->format('%r%Y-%M-%D %H:%I:%S.%F'), '00-00-00 05:06:42.023456');
    }

    /**
     * @test
     */
    public function instantiateFromInvertedDifference()
    {
        $now = '2020-09-23';
        $then = new \DateTime("$now - 5 hours - 6 minutes");
        $when = new \DateTime("$now + 42 seconds + 23456 microseconds");

        $duration = Duration::fromDifference($when, $then);

        $this->assertSame($duration->asSeconds(), -(5 * 3600) - (6 * 60) - 42);
        $this->assertSame($duration->format('%r%Y-%M-%D %H:%I:%S.%F'), '-00-00-00 05:06:42.023456');
    }

    /**
     * @test
     */
    public function addInterval()
    {
        $duration = Duration::fromString('@40');
        $duration->add(Duration::fromString('@2'));

        $this->assertSame($duration->asSeconds(), 42);
    }

    /**
     * @test
     */
    public function subtractInterval()
    {
        $duration = Duration::fromString('@44');
        $duration->subtract(Duration::fromString('@2'));

        $this->assertSame($duration->asSeconds(), 42);
    }

    /**
     * @test
     */
    public function measureInterval()
    {
        $duration = new Duration();
        $duration->start();
        sleep(2);
        $duration->stop();

        $this->assertSame($duration->asSeconds(), 2);
    }

    /**
     * @test
     */
    public function requestedTestCase()
    {
        $duration = Duration::from(52200);

        $this->assertSame($duration->format('%H:%i'), '14:30'); // Should out 14:30 (hours and minutes)
//        $this->assertSame($duration->format('%D'), 0.6042); // Should output ~0.6042 days
        $this->assertSame($duration->asMinutes(), 870); // 870 minutes
    }

    /**
     * @test
     */
    public function toHoursMinutes()
    {
        $duration = Duration::from(52200);

        $this->assertSame($duration->toHoursMinutes(), '14:30'); // Should out 14:30 (hours and minutes)
        $this->assertSame($duration->toHoursMinutes(true), '14 hours 30 minutes');
    }

    /**
     * @test
     */
    public function toDaysHoursMinutes()
    {
        $duration = Duration::from(225000);

        $this->assertSame($duration->asSeconds(), 225000);
        $this->assertSame($duration->toDaysHoursMinutes(), '2-14:30'); // Should out 14:30 (hours and minutes)
        $this->assertSame($duration->toDaysHoursMinutes(true), '2 days 14 hours 30 minutes');
    }

    /**
     * @test
     */
    public function toSignedHoursMinutes()
    {
        $duration = Duration::from(-52200);

        $this->assertSame($duration->asSeconds(), -52200);
        $this->assertSame($duration->toHoursMinutes(), '-14:30'); // Should out 14:30 (hours and minutes)
        $this->assertSame($duration->toHoursMinutes(true), '-14 hours 30 minutes');
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
        $this->assertSame('6:56', $duration->toString());
        $this->assertSame('6 hours 56 minutes', (string)$duration);

        $duration->subtract(Duration::from(24641));
        $this->assertSame('05:59', $duration->toString());
        $this->assertSame('05 minutes 59 seconds', (string)$duration);
    }
}
