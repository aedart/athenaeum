<?php

namespace Aedart\Testing\Laravel\Database;

use Illuminate\Testing\PendingCommand;

/**
 * Migrate Processor
 *
 * Customised version of Orchestra's Migrate Processor.
 * This version does not restrict the test class to be an instance of Orchestra's TestCase
 *
 * @see \Orchestra\Testbench\Database\MigrateProcessor
 * @see \Orchestra\Testbench\Contracts\TestCase
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Testing\Laravel\Database
 */
class MigrateProcessor
{
    /**
     * The test instance
     *
     * @var mixed
     */
    protected mixed $test;

    /**
     * The migrator options.
     *
     * @var array
     */
    protected array $options = [];

    /**
     * MigratorProcessor
     *
     * @param mixed $test
     * @param array $options [optional]
     */
    public function __construct(mixed $test, array $options = [])
    {
        $this->test = $test;
        $this->options = $options;
    }

    /**
     * Run migration.
     *
     * @return self
     */
    public function up(): self
    {
        $this->dispatch('migrate');

        return $this;
    }

    /**
     * Rollback migration.
     *
     * @return self
     */
    public function rollback(): self
    {
        $this->dispatch('migrate:rollback');

        return $this;
    }

    /**
     * Dispatch artisan command.
     *
     * @param  string $command
     *
     * @return void
     */
    protected function dispatch(string $command): void
    {
        tap($this->test->artisan($command, $this->options), function ($artisan) {
            if ($artisan instanceof PendingCommand) {
                $artisan->run();
            }
        });
    }
}
