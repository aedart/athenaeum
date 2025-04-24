<?php

namespace Aedart\Tests\Integration\Audit;

use Aedart\Audit\Concerns\ChangeRecording;
use Aedart\Audit\Events\MultipleModelsChanged;
use Aedart\Audit\Models\AuditTrail;
use Aedart\Tests\Helpers\Dummies\Audit\Category;
use Aedart\Tests\TestCases\Audit\AuditTestCase;
use Codeception\Attribute\Group;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\Test;

/**
 * C0_MultipleModelsChangedRecordingTest
 *
 * @group audit
 * @group audit-trail
 * @group audit-trail-multiple-changes-recording
 * @group audit-c0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Audit
 */
#[Group(
    'audit',
    'audit-trail',
    'audit-trail-multiple-changes-recording',
    'audit-c0',
)]
class C0_MultipleModelsChangedRecordingTest extends AuditTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function recordsMultipleModelsChanged()
    {
        // a) mass insert new records
        $entries = $this->makeCategoriesData();
        Category::query()
            ->insert($entries);

        // b) Obtain inserted (changed) models
        $models = Category::all();

        // c) Build and dispatch multiple models changed
        // NOTE: We ignore original and changed data for this test...
        $type = $this->getFaker()->slug();
        MultipleModelsChanged::dispatch($models, null, $type, [], []);

        // ---------------------------------------------------------- //

        /** @var Collection<AuditTrail>|AuditTrail[] $history */
        $history = AuditTrail::all();

        // ---------------------------------------------------------- //

        $this->assertCount(count($entries), $history, 'Incorrect amount of audit trail entries recorded');

        foreach ($history as $entry) {
            $this->assertSame(Category::class, $entry['auditable_type'], 'Incorrect class path');
            $this->assertSame($type, $entry['type'], 'Incorrect event type');
            $this->assertNotEmpty($entry['message'], 'A message was expected'); // See Category::getAuditTrailMessage()
        }

        // Verify that history / audit trail entries can be obtained via model.
        /** @var Model & ChangeRecording $last */
        $last = $models->last();
        $auditTrails = $last->recordedChanges()->get();

        $this->assertNotEmpty($auditTrails, 'no audit trail entries for last model');
        $this->assertSame(1, $auditTrails->count(), 'Incorrect amount of audit trail entries for last model');
    }
}
