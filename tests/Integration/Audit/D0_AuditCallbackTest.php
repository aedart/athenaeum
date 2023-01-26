<?php

namespace Aedart\Tests\Integration\Audit;

use Aedart\Audit\Helpers\Callback;
use Aedart\Audit\Models\AuditTrail;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Audit\AuditTestCase;
use Illuminate\Database\Eloquent\Collection;

/**
 * D0_AuditCallbackTest
 *
 * @group audit
 * @group audit-trail
 * @group audit-callback
 * @group audit-callback-reason
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Audit
 */
class D0_AuditCallbackTest extends AuditTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function canSpecifyCustomReasonForAuditTrails(): void
    {
        $reason = $this->getFaker()->sentence();

        $category = Callback::perform(function () {
            $category = $this->makeCategory();

            $category->save();

            return $category->refresh();
        })
            ->because($reason)
            ->execute();

        // -------------------------------------------------------- //

        /** @var AuditTrail $history */
        $history = $category->recordedChanges()->first();

        ConsoleDebugger::output([
            'reason' => $reason,
            'audit_trail_msg' => $history->message
        ]);

        // -------------------------------------------------------- //

        $this->assertNotNull($history);
        $this->assertSame($reason, $history->message);
    }

    /**
     * @test
     *
     * @return void
     */
    public function canRestorePreviousReasons(): void
    {
        $reason = 'a';

        $category = Callback::perform(function () {
            $categoryA = $this->makeCategory();

            $changed = Callback::perform(function () use ($categoryA) {
                $categoryA
                    ->forceFill([
                        'name' => 'other name',
                    ])
                    ->save();

                return $categoryA;
            })->because('b')->execute();

            $categoryA
                ->forceFill([
                    'name' => 'yet another name'
                ])
                ->save();

            return $changed;
        })
            ->because($reason)
            ->execute();

        // -------------------------------------------------------- //

        /** @var Collection<AuditTrail> $history */
        $history = $category->recordedChanges()->get();

        ConsoleDebugger::output($history->toArray());

        // -------------------------------------------------------- //

        $this->assertNotNull($history);
        $this->assertCount(2, $history);

        $this->assertSame('b', $history[0]->message);
        $this->assertSame('a', $history[1]->message);
    }
}
