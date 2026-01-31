<?php

namespace Aedart\Tests\Integration\Audit;

use Aedart\Audit\Helpers\BulkRecorder;
use Aedart\Audit\Models\AuditTrail;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Audit\Category;
use Aedart\Tests\Helpers\Dummies\Audit\User;
use Aedart\Tests\TestCases\Audit\AuditTestCase;
use Codeception\Attribute\Group;
use LogicException;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

/**
 * E0_BulkRecorderTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Audit
 */
#[Group(
    'audit',
    'audit-trail',
    'audit-bulk-recorder',
    'audit-d0',
)]
class E0_BulkRecorderTest extends AuditTestCase
{
    /**
     * @return void
     *
     * @throws Throwable
     */
    #[Test]
    public function canRecordBulkChangesForIdentifiers(): void
    {
        $entries = $this->makeCategoriesData();
        Category::query()
            ->insert($entries);

        $identifiers = collect($entries)
            ->pluck('slug')
            ->toArray();

        $type = 'my_custom_event_type';
        $changed = [
            'a' => true
        ];

        // --------------------------------------------------------------------- //

        BulkRecorder::recordChangedFor(
            modelType: Category::class,
            identifiers: $identifiers,
            type: $type,
            changed: $changed
        );

        // --------------------------------------------------------------------- //

        $history = AuditTrail::all();
        ConsoleDebugger::output($history->toArray());

        // --------------------------------------------------------------------- //

        $this->assertCount(count($entries), $history, 'incorrect amount of audit trail entries');

        foreach ($history as $entry) {
            $this->assertSame($type, $entry->type, 'Incorrect event type set in audit trail entry');
            $this->assertSame($changed, $entry->changed_data, 'Incorrect event type set in audit trail entry');
        }
    }

    /**
     * @return void
     *
     * @throws Throwable
     */
    #[Test]
    public function failsWhenModelNotSluggableAndSlugsIdentifiersGiven(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage(sprintf('%s is not Sluggable, but list of string identifiers has been provided', User::class));

        BulkRecorder::recordChangedFor(
            modelType: User::class,
            identifiers: [ 'a', 'b', 'c' ],
            type: 'some type',
        );
    }

    /**
     * @return void
     *
     * @throws Throwable
     */
    #[Test]
    public function canRecordBulkChangesForCollection(): void
    {
        $entries = $this->makeCategoriesData();
        Category::query()
            ->insert($entries);

        $collection = Category::all();
        $type = 'added_extra_meta';
        $changed = [
            'a' => true,
            'b' => false,
            'c' => 42
        ];

        // --------------------------------------------------------------------- //

        BulkRecorder::recordModelsChanged(
            models: $collection,
            type: $type,
            changed: $changed
        );

        // --------------------------------------------------------------------- //

        $history = AuditTrail::all();
        ConsoleDebugger::output($history->toArray());

        // --------------------------------------------------------------------- //

        $this->assertCount(count($entries), $history, 'incorrect amount of audit trail entries');

        foreach ($history as $entry) {
            $this->assertSame($type, $entry->type, 'Incorrect event type set in audit trail entry');
            $this->assertSame($changed, $entry->changed_data, 'Incorrect event type set in audit trail entry');
        }
    }
}
