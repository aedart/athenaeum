<?php

namespace Aedart\Tests\TestCases\Http;

use Aedart\Tests\Helpers\Dummies\Http\Api\Models\User;

/**
 * Api Resource Requests Test Case
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
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

        $this->seedUsers();
    }

    /*****************************************************************
     * Dummy Data
     ****************************************************************/

    /**
     * Seeds the users table with dummy records
     *
     * @return void
     */
    protected function seedUsers(): void
    {
        User::factory()
            ->count(25)
            ->create();
    }
}
