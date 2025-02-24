<?php

namespace Aedart\Contracts\Support\Helpers\Console;

/**
 * Console Schedule Aware
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Support\Helpers\Console
 */
interface ScheduleAware
{
    /**
     * Set schedule
     *
     * @param \Illuminate\Console\Scheduling\Schedule|null $schedule Console Schedule instance
     *
     * @return self
     */
    public function setSchedule($schedule): static;

    /**
     * Get schedule
     *
     * If no schedule has been set, this method will
     * set and return a default schedule, if any such
     * value is available
     *
     * @return \Illuminate\Console\Scheduling\Schedule|null schedule or null if none schedule has been set
     */
    public function getSchedule();

    /**
     * Check if schedule has been set
     *
     * @return bool True if schedule has been set, false if not
     */
    public function hasSchedule(): bool;

    /**
     * Get a default schedule value, if any is available
     *
     * @return \Illuminate\Console\Scheduling\Schedule|null A default schedule value or Null if no default value is available
     */
    public function getDefaultSchedule();
}