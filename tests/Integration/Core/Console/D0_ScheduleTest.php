<?php

namespace Aedart\Tests\Integration\Core\Console;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Console\AthenaeumCoreConsoleTestCase;
use Codeception\Attribute\Group;
use Illuminate\Console\Scheduling\Schedule;
use PHPUnit\Framework\Attributes\Test;

/**
 * D0_ScheduleTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Console
 */
#[Group(
    'application',
    'application-console',
    'application-console-d0',
)]
class D0_ScheduleTest extends AthenaeumCoreConsoleTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Resolves the artisan console application
     */
    protected function resolveArtisanApp()
    {
        // Define path to where artisan binary is located.
        // NOTE: This is used for schedule execution!
        // TODO: This cannot be done via env!
        //$path = Configuration::dataDir() . 'console/artisan';
        //putenv("ARTISAN_BINARY='{$path}'");

        // This will force the application to register the service
        // provider and thus that the schedules are defined...
        $artisan = $this->getArtisan();
        $artisan->all();
    }

    /**
     * Returns the bound schedule instance
     *
     * @return Schedule
     */
    protected function getSchedule()
    {
        /** @var Schedule $schedule */
        $schedule = $this->app->make(Schedule::class);
        $this->assertNotNull($schedule, 'No schedule instance registered');

        return $schedule;
    }

    /*****************************************************************
     * Actual tests
     ****************************************************************/

    #[Test]
    public function hasRegisteredScheduledTasksFromConfig()
    {
        // Ensure console kernel and application are resolved
        $this->resolveArtisanApp();

        // Obtain schedule:
        $schedule = $this->getSchedule();

        // Obtain all scheduled tasks (events)
        $events = $schedule->events();
        $this->assertNotEmpty($events, 'No events');
    }

    #[Test]
    public function canRunSchedule()
    {
        // Ensure console kernel and application are resolved
        $this->resolveArtisanApp();

        $exitCode = $this
            ->withoutMockingConsoleOutput()
            ->artisan('schedule:run');

        $output = $this->getArtisan()->output();
        ConsoleDebugger::output($output);

        $this->assertSame(0, $exitCode, 'Incorrect exist code');
        $this->assertStringContainsString('A command that does nothing', $output);
    }
}
