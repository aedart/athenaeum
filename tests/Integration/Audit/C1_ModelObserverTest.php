<?php

namespace Aedart\Tests\Integration\Audit;

use Aedart\Audit\Models\AuditTrail;
use Aedart\Audit\Observers\ModelObserver;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Audit\Category;
use Aedart\Tests\TestCases\Audit\AuditTestCase;
use Codeception\Attribute\Group;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

/**
 * C1_ModelObserverTest
 *
 * @group audit
 * @group audit-trail
 * @group audit-trail-observer
 * @group audit-c1
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Audit
 */
#[Group(
    'audit',
    'audit-trail',
    'audit-trail-observer',
    'audit-c1',
)]
class C1_ModelObserverTest extends AuditTestCase
{
    /**
     * @test
     *
     * @return void
     *
     * @throws Throwable
     */
    #[Test]
    public function canSkipRecordingForSomeModels(): void
    {
        // a) mass insert new records
        $entries = $this->makeCategoriesData(5);
        Category::query()
            ->insert($entries);

        // b) Obtain inserted (changed) models
        $models = Category::all();

        // c) Mark "skip recording" for some models.
        $models[0]->skipRecordingNextChange();
        $models[1]->skipRecordingNextChange();

        // ---------------------------------------------------------- //

        $skipped = $models->filter(function ($model) {
            return !$model->mustRecordNextChange();
        });
        ConsoleDebugger::output([
            'skipped' => $skipped->toArray()
        ]);

        // ---------------------------------------------------------- //

        // d) Build and dispatch multiple models changed
        $type = $this->getFaker()->slug();
        $observer = new ModelObserver();
        $observer->dispatchMultipleModelsChanged($models, $type, [], []);

        // ---------------------------------------------------------- //

        /** @var Collection<AuditTrail>|AuditTrail[] $history */
        $history = AuditTrail::all();

        // ---------------------------------------------------------- //

        // 2 of the models are marked as "skip recording"...
        $this->assertCount(count($entries) - 2, $history, 'Incorrect amount of audit trail entries recorded');
    }
}
