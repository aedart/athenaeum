<?php


namespace Aedart\Tests\TestCases\Audit;

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
        $this->assertTrue(Schema::hasTable('audit_table'), 'table not migrated');
    }
}