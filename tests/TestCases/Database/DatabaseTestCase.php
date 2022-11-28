<?php

namespace Aedart\Tests\TestCases\Database;

use Aedart\Testing\Laravel\Database\TestingConnection;
use Aedart\Testing\TestCases\LaravelTestCase;

/**
 * Database Test Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Database
 */
abstract class DatabaseTestCase extends LaravelTestCase
{
    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * @inheritDoc
     */
    protected function _before()
    {
        parent::_before();

        $this->installMigrations();
    }

    /**
     * @inheritdoc
     */
    protected function getEnvironmentSetUp($app)
    {
        TestingConnection::enableConnection();
    }

    /*****************************************************************
     * Paths
     ****************************************************************/

    /**
     * Returns paths to where database migrations are located
     *
     * @return string
     */
    public function migrationsDir(): string
    {
        return __DIR__ . '/../../_data/database/migrations';
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Runs the database migrations for the ACL package
     *
     * @return self
     */
    public function installMigrations(): self
    {
        // Install default migrations
        // $this->loadLaravelMigrations();

        // Install custom migrations
        $this->loadMigrationsFrom(
            $this->migrationsDir()
        );

        return $this;
    }
}
