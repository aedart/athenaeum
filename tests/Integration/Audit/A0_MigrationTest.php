<?php

namespace Aedart\Tests\Integration\Audit;

use Illuminate\Support\Facades\Schema;

/**
 * A0_MigrationTest
 *
 * @group audit
 * @group audit-trail
 * @group audit-a0
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\TestCases\Audit
 */
class A0_MigrationTest extends AuditTestCase
{
    /**
     * @test
     */
    public function hasInstalledMigration()
    {
        // By Laravel application
        $this->assertTrue(Schema::hasTable('users'), 'users table not migrated');

        // Audit package...
        $this->assertTrue(Schema::hasTable('audit_trails'), 'audit trails table not migrated');
    }
}