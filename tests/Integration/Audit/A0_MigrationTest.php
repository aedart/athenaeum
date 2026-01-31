<?php

namespace Aedart\Tests\Integration\Audit;

use Aedart\Tests\TestCases\Audit\AuditTestCase;
use Codeception\Attribute\Group;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;

/**
 * A0_MigrationTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Audit
 */
#[Group(
    'audit',
    'audit-trail',
    'audit-a0',
)]
class A0_MigrationTest extends AuditTestCase
{
    #[Test]
    public function hasInstalledMigration()
    {
        // By Laravel application
        $this->assertTrue(Schema::hasTable('users'), 'users table not migrated');

        // Audit package...
        $this->assertTrue(Schema::hasTable('audit_trails'), 'audit trails table not migrated');
    }
}
