<?php

namespace Aedart\Tests\TestCases\Acl;

use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Testing\TestCases\LaravelTestCase;
use Codeception\Configuration;

/**
 * AclTestCase
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\TestCases\Acl
 */
abstract class AclTestCase extends LaravelTestCase
{
    use ConfigLoaderTrait;

    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * @inheritDoc
     */
    protected function _before()
    {
        parent::_before();

        $this->getConfigLoader()
            ->setDirectory($this->configDir())
            ->load();
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            ConfigLoaderServiceProvider::class,
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');

        // Enable foreign key constraints for SQLite testing database
        $app['config']->set('database.connections.testing.foreign_key_constraints', true);
    }

    /*****************************************************************
     * Paths
     ****************************************************************/

    /**
     * Returns path to configuration directory
     *
     * @return string
     */
    public function configDir(): string
    {
        return Configuration::dataDir() . 'configs/acl/';
    }

    /**
     * Returns paths to where database migrations are located
     *
     * @return string
     */
    public function migrationsDir(): string
    {
        return __DIR__ . '/../../../packages/Acl/database/migrations';
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Runs the database migrations for the ACL package
     *
     * @return self
     */
    public function installAclMigrations(): self
    {
        $this->loadMigrationsFrom(
            $this->migrationsDir()
        );

        return $this;
    }

    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Returns permissions data to be used by \Aedart\Acl\Models\Permissions\Group::createWithPermissions
     *
     * @return \string[][]
     */
    public function makePermissionsForGroupCreate(): array
    {
        return [
            'index' => [ 'name' => 'List', 'description' => 'Ability to see list of users' ],
            'show' => [ 'name' => 'Read', 'description' => 'Ability to see individual users' ],
            'store' => [ 'name' => 'Create', 'description' => 'Ability to create new users' ],
            'update' => [ 'name' => 'Update', 'description' => 'Ability to update existing users' ],
            'delete' => [ 'name' => 'Delete', 'description' => 'Ability to delete existing users' ],
        ];
    }
}