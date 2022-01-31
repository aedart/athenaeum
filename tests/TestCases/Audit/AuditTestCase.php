<?php

namespace Aedart\Tests\TestCases\Audit;

use Aedart\Audit\Providers\AuditTrailServiceProvider;
use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Testing\TestCases\LaravelTestCase;
use Aedart\Tests\Helpers\Dummies\Audit\Category;
use Aedart\Tests\Helpers\Dummies\Audit\User;
use Codeception\Configuration;
use Illuminate\Support\Facades\Hash;

/**
 * Audit Test Case
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\TestCases\Audit
 */
abstract class AuditTestCase extends LaravelTestCase
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

        $this->installAuditMigrations();
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            ConfigLoaderServiceProvider::class,
            AuditTrailServiceProvider::class,
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
        return Configuration::dataDir() . 'configs/audit/';
    }

    /**
     * Returns paths to where database migrations are located
     *
     * @return string
     */
    public function packageMigrationsDir(): string
    {
        return __DIR__ . '/../../../packages/Audit/database/migrations';
    }

    /**
     * Returns paths to where tests migrations are located
     *
     * @return string
     */
    public function migrationsDirForTests(): string
    {
        return __DIR__ . '/../../_data/database/migrations';
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Runs the database migrations for the Audit package
     *
     * @return self
     */
    public function installAuditMigrations(): self
    {
        // Install default migrations
        $this->loadLaravelMigrations();

        // Install custom migrations
        $this->loadMigrationsFrom($this->packageMigrationsDir()); // NOT needed!
        $this->loadMigrationsFrom($this->migrationsDirForTests());

        return $this;
    }

    /*****************************************************************
     * Factories
     ****************************************************************/

    /**
     * Returns a new Category instance, populated with dummy data
     *
     * @param array $data [optional]
     *
     * @return Category
     */
    public function makeCategory(array $data = []): Category
    {
        $faker = $this->getFaker();

        return new Category(array_merge([
            'slug' => $faker->unique()->slug(3),
            'name' => $faker->words(4, true),
            'description' => $faker->sentence
        ], $data));
    }

    /**
     * Generates multiple "categories" records data
     *
     * @param int $amount [optional]
     * @param array $data [optional]
     *
     * @return array
     */
    public function makeCategoriesData(int $amount = 3, array $data = []): array
    {
        $faker = $this->getFaker();

        $output = [];
        while($amount--) {
            $output[] = array_merge([
                'slug' => $faker->unique()->slug(3),
                'name' => $faker->words(4, true),
                'description' => $faker->sentence()
            ], $data);
        }

        return $output;
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
