<?php


namespace Aedart\Audit\Listeners;

use Aedart\Audit\Events\ModelHasChanged;
use Aedart\Audit\Models\Concerns;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Record Audit Trail Entry - Event Listener
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Audit\Listeners
 */
class RecordAuditTrailEntry implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use Concerns\AuditTrailConfiguration;

    /**
     * The number of times the queued listener may be attempted.
     *
     * @var int
     */
    public $tries;

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

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Determine if a user exists with the given id
     *
     * @param string|int $id
     *
     * @return bool
     */
    protected function userExists($id): bool
    {
        $model = $this->auditTrailUserModelInstance();

        return $model
            ->newQuery()
            ->where($model->getKeyName(), $id)
            ->exists();
    }

    /**
     * Configure queue settings for this listener
     *
     * @return self
     */
    protected function configureQueueSettings()
    {
        $config = $this->getConfig()->get('audit-trail.queue', []);

        $this->connection = $config['connection'] ?? 'sync';
        $this->queue = $config['queue'] ?? 'default';
        $this->delay = $config['delay'] ?? null;
        $this->tries = $config['retries'] ?? 1;

        return $this;
    }
}
