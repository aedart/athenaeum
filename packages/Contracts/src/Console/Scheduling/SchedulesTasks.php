<?php

namespace Aedart\Contracts\Console\Scheduling;

/**
 * Schedules Tasks
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Console\Scheduling
 */
interface SchedulesTasks
{
    /**
     * Defines tasks to be executed when they are due
     *
     * @see https://laravel.com/docs/6.x/scheduling
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    public function schedule($schedule): void;
}
