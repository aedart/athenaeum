<?php

namespace Aedart\Tests\Integration\Audit;

use Aedart\Audit\Helpers\Callback;
use Aedart\Audit\Models\AuditTrail;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Audit\AuditTestCase;

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
}
