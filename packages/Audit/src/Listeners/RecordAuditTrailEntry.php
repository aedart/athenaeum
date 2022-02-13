<?php

namespace Aedart\Audit\Listeners;

use Aedart\Audit\Events\ModelHasChanged;

/**
 * Record Audit Trail Entry - Event Listener
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Audit\Listeners
 */
class RecordAuditTrailEntry extends RecordsEntries
{
    /**
     * RecordAuditTrailEntry constructor.
     */
    public function __construct()
    {
        $this->afterCommit = true;

        $this->configureQueueSettings();
    }

    /**
     * Records a new Audit Trail Entry, based on given
     * "model has changed" event
     *
     * @param ModelHasChanged $event
     *
     * @return void
     */
    public function handle(ModelHasChanged $event)
    {
        // In rare situations, the provided user that caused the event might be force-deleted,
        // in which case inserting the audit trail entry will fail, due to its foreign-key
        // constraint.
        //
        // Depending on your perspective, you might see this as a design flaw. However, the
        // table is intended to have accurate information about which existing user caused
        // a change. If the user is removed after the change has been recorded, then the
        // foreign-key is set to null. Ideally, users should only be soft-deleted and never
        // force deleted.
        //
        // Nevertheless, to ensure that the insert operation does not fail, we must check
        // whether the user exists or not. If the latter is the case, then we set the user
        // to null.
        $userId = $event->user;
        if (!$this->userExists($userId)) {
            $userId = null;
        }

        // Insert new Audit Trail Entry
        $this->auditTrailModelInstance()
            ->fill([
                'user_id' => $userId,
                'auditable_type' => $event->model,
                'auditable_id' => $event->id,
                'type' => $event->type,
                'message' => $event->message,
                'original_data' => $event->original,
                'changed_data' => $event->changed,
                'performed_at' => $event->performedAt
            ])
            ->save();
    }
}
