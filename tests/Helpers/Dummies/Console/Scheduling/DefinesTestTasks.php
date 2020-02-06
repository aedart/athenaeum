<?php

namespace Aedart\Tests\Helpers\Dummies\Console\Scheduling;

use Aedart\Contracts\Console\Scheduling\SchedulesTasks;
use Aedart\Tests\Helpers\Dummies\Console\Commands\DoesNothingCommand;

/**
 * Defines Test Tasks
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Console\Scheduling
 */
class DefinesTestTasks implements SchedulesTasks
{
    /**
     * @inheritDoc
     */
    public function schedule($schedule): void
    {
        // NOTE: By not stating time constraints, e.g. daily(),
        // this command should be invoked immediately during tests.
        $schedule
            ->command(DoesNothingCommand::class)
            ->name('does nothing')
            ->description('A command that does nothing');

            // Cannot test send output, because of ARTISAN_BINARY const!
            // Manually tested via executing ./artisan schedule:run, in
            // tests/_data/console/artisan
            //->sendOutputTo(storage_path('schedule.log'));
    }
}
