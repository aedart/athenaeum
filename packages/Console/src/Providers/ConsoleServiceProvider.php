<?php

namespace Aedart\Console\Providers;

use Aedart\Contracts\Console\Scheduling\SchedulesTasks;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Illuminate\Console\Events\ArtisanStarting;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Console\Scheduling\ScheduleFinishCommand;
use Illuminate\Console\Scheduling\ScheduleRunCommand;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use LogicException;
use RuntimeException;

/**
 * Console Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Console\Providers
 */
class ConsoleServiceProvider extends ServiceProvider implements DeferrableProvider
{
    use ConfigTrait;

    /**
     * @inheritdoc
     *
     * @throws BindingResolutionException
     */
    public function register()
    {
        $this->registerSchedule();
    }

    /**
     * Bootstrap this service
     *
     * @throws BindingResolutionException
     */
    public function boot()
    {
        $this
            ->publishConfig()
            ->registerAvailableCommands()
            ->registerScheduleCommands()
            ->registerSchedulesFromConfig();
    }

    /**
     * @inheritdoc
     */
    public function when()
    {
        // Ensure that provider does not trigger unless artisan
        // is starting
        return [
            ArtisanStarting::class
        ];
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Register commands available in configuration
     *
     * @return self
     *
     * @throws RuntimeException If no register command method available
     */
    protected function registerAvailableCommands(): static
    {
        $commands = $this->getConfig()->get('commands', []);

        $this->commands($commands);

        return $this;
    }

    /**
     * Register the schedule command(s)
     *
     * @return self
     */
    protected function registerScheduleCommands(): static
    {
        $this->commands([
            ScheduleRunCommand::class,
            ScheduleFinishCommand::class
        ]);

        return $this;
    }

    /**
     * Register scheduled tasks from configuration
     *
     * @return self
     *
     * @throws BindingResolutionException
     * @throws LogicException If given schedules cannot be resolved
     */
    protected function registerSchedulesFromConfig(): static
    {
        /** @var Schedule $schedule */
        $schedule = $this->app->make(Schedule::class);

        $tasks = $this->getConfig()->get('schedule.tasks', []);

        foreach ($tasks as $schedules) {
            $this->addSchedules($schedules, $schedule);
        }

        return $this;
    }

    /**
     * Register scheduled tasks via given schedules instance
     *
     * @param string $schedules Class path
     * @param Schedule $schedule
     *
     * @throws BindingResolutionException
     * @throws LogicException If given schedules cannot be resolved
     */
    protected function addSchedules(string $schedules, Schedule $schedule)
    {
        $scheduler = $this->app->make($schedules);
        if (!($scheduler instanceof SchedulesTasks)) {
            throw new LogicException(sprintf('%s must be instance of %s', $schedules, SchedulesTasks::class));
        }

        $scheduler->schedule($schedule);
    }

    /**
     * Register the Laravel schedule instance
     *
     * @return self
     *
     * @throws BindingResolutionException
     */
    protected function registerSchedule(): static
    {
        $config = $this->getConfig();
        $timezone = $config->get('schedule.timezone', $config->get('app.timezone'));
        $cacheStore = $config->get('schedule.cache', 'null');

        // If a schedule already bound...
        if ($this->app->bound(Schedule::class)) {
            // NOTE: At this point, we are unable to (re)specify the timezone!
            // But we can instruct what cache store the schedule should use.

            /** @var Schedule $schedule */
            $schedule = $this->app->make(Schedule::class);
            $schedule->useCache($cacheStore);

            return $this;
        }

        // This could mean that we are not within a Laravel application,
        // therefore we bind the schedule instance
        $this->app->singleton(Schedule::class, function () use ($timezone, $cacheStore) {
            return (new Schedule($timezone))
                ->useCache($cacheStore);
        });

        return $this;
    }

    /**
     * Publish example configuration
     *
     * @return self
     */
    protected function publishConfig(): static
    {
        $this->publishes([
            __DIR__ . '/../../configs/commands.php' => config_path('commands.php'),
            __DIR__ . '/../../configs/schedule.php' => config_path('schedule.php'),
        ], 'config');

        return $this;
    }
}
