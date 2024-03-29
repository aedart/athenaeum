<?php

namespace Aedart\Tests\TestCases\Http;

use Aedart\Filters\Providers\FiltersServiceProvider;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Game;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Owner;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\User;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\OwnerResource;

/**
 * Api Resource Requests Test Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Http
 */
abstract class ApiResourceRequestsTestCase extends ApiResourcesTestCase
{
    /**
     * When true, migrations for this test-case will
     * be installed.
     *
     * @var bool
     */
    protected bool $installMigrations = true;

    /**
     * @inheritDoc
     */
    protected function _before()
    {
        parent::_before();

        $this
            ->seedUsers()
            ->seedGames();

        $this->registerResources();
    }

    /**
     * @inheritDoc
     */
    protected function getPackageProviders($app): array
    {
        return array_merge(parent::getPackageProviders($app), [
            FiltersServiceProvider::class
        ]);
    }

    /**
     * Registers resources for tests
     *
     * @return self
     */
    protected function registerResources(): static
    {
        $registrar = $this->getApiResourceRegistrar();

        $registrar->register([
            Owner::class => OwnerResource::class
        ]);

        return $this;
    }

    /*****************************************************************
     * Dummy Data
     ****************************************************************/

    /**
     * Seeds the users table with dummy records
     *
     * @return self
     */
    protected function seedUsers(): static
    {
        User::factory()
            ->count(25)
            ->create();

        return $this;
    }

    /**
     * Seeds the games table with dummy records
     *
     * @return self
     */
    public function seedGames(): static
    {
        Game::factory()
            ->count(25)
            ->create();

        return $this;
    }
}
