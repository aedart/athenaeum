<?php

namespace Aedart\Support\Helpers\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Schedule as ScheduleFacade;

/**
 * Console Schedule Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Console\ScheduleAware
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Support\Helpers\Console
 */
trait ScheduleTrait
{
    /**
     * Console Schedule instance
     *
     * @var Schedule|null
     */
    protected Schedule|null $schedule = null;

    /**
     * Set schedule
     *
     * @param \Illuminate\Console\Scheduling\Schedule|null $schedule Console Schedule instance
     *
     * @return self
     */
    public function setSchedule($schedule): static
    {
        $this->schedule = $schedule;

        return $this;
    }

    /**
     * Get schedule
     *
     * If no schedule has been set, this method will
     * set and return a default schedule, if any such
     * value is available
     *
     * @return \Illuminate\Console\Scheduling\Schedule|null schedule or null if none schedule has been set
     */
    public function getSchedule()
    {
        if (!$this->hasSchedule()) {
            $this->setSchedule($this->getDefaultSchedule());
        }
        return $this->schedule;
    }

    /**
     * Check if schedule has been set
     *
     * @return bool True if schedule has been set, false if not
     */
    public function hasSchedule(): bool
    {
        return isset($this->schedule);
    }

    /**
     * Get a default schedule value, if any is available
     *
     * @return \Illuminate\Console\Scheduling\Schedule|null A default schedule value or Null if no default value is available
     */
    public function getDefaultSchedule()
    {
        return ScheduleFacade::getFacadeRoot();
    }
}
