<?php

namespace Aedart\Tests\TestCases\Acl;

use Aedart\Acl\Models\Permissions\Group;
use Aedart\Acl\Models\Role;
use Aedart\Acl\Traits\AclTrait;
use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Testing\TestCases\LaravelTestCase;
use Aedart\Tests\Helpers\Dummies\Acl\User;
use Codeception\Configuration;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

/**
 * AclTestCase
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\TestCases\Acl
 */
abstract class AclTestCase extends LaravelTestCase
{
    use ConfigLoaderTrait;
    use AclTrait;

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
        // Install default migrations
        $this->loadLaravelMigrations();

        // Install custom migrations
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

    /*****************************************************************
     * Factories
     ****************************************************************/

    /**
     * Creates and persists a new permission group
     *
     * @param array $attributes [optional]
     *
     * @return Group
     */
    public function createPermissionGroup(array $attributes = []): Group
    {
        $faker = $this->getFaker();

        $attributes = array_merge([
            'slug' => $faker->unique()->slug,
            'name' => $faker->words(3, true),
            'description' => $faker->words(20, true)
        ], $attributes);

        return Group::create($attributes);
    }

    /**
     * Creates and persists a new permission group with given permissions
     *
     * @param string $slug
     * @param array|null $permissions [optional] If none given then a default set of permissions is used
     * @param string|null $name [optional]
     * @param string|null $description [optional]
     * @param bool $prefix [optional]
     *
     * @return Group
     *
     * @throws \Throwable
     */
    public function createPermissionGroupWithPermissions(
        string $slug,
        ?array $permissions = null,
        ?string $name = null,
        ?string $description = null,
        bool $prefix = true
    ): Group {
        $permissions = $permissions ?? $this->makePermissionsForGroupCreate();

        return Group::createWithPermissions($slug, $permissions, $name, $description, $prefix);
    }

    /**
     * Creates and persists a new role
     *
     * @param array $attributes [optional]
     *
     * @return Role
     */
    public function createRole(array $attributes = []): Role
    {
        $faker = $this->getFaker();

        $attributes = array_merge([
            'slug' => $faker->unique()->slug,
            'name' => $faker->words(3, true),
            'description' => $faker->words(20, true)
        ], $attributes);

        return Role::create($attributes);
    }

    /**
     * Creates multiple roles
     *
     * @param int $amount [optional]
     *
     * @return Collection|Role[]
     */
    public function createRoles(int $amount = 3)
    {
        $roles = [];
        while($amount--) {
            $roles[] = $this->createRole();
        }

        return new Collection($roles);
    }

    /**
     * Creates and persists a new dummy user
     *
     * @param array $attributes [optional]
     *
     * @return User
     */
    public function createUser(array $attributes = []): User
    {
        $faker = $this->getFaker();

        $attributes = array_merge([
            'email' => $faker->unique()->email,
            'name' => $faker->name,
            'password' => Hash::make('password')
        ], $attributes);

        return User::create($attributes);
    }
}
