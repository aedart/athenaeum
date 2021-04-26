<?php


namespace Aedart\Audit\Listeners;

use Aedart\Audit\Events\ModelHasChanged;
use Aedart\Audit\Models\Concerns;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
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
     * Handle listener after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * RecordAuditTrailEntry constructor.
     */
    public function __construct()
    {
        $this->configureQueueSettings();
    }

    /**
     * Records an new Audit Trail Entry, based on given
     * "model has changed" event
     *
     * @param ModelHasChanged $event
     *
     * @return void
     */
    public function handle(ModelHasChanged $event)
    {
        $model = $event->model;

        // Obtain original and changed data
        $original = $this->resolveModelData($model, 'originalData', function (Model $model) {
            return $model->getOriginal();
        });

        $changed = $this->resolveModelData($model, 'changedData', function (Model $model) {
            return $model->getAttributes();
        });

        // Insert new Audit Trail Entry
        $this->auditTrailUserModelInstance()
            ->fill([
                'user_id' => optional($event->user)->id,
                'auditable_type' => get_class($model),
                'auditable_id' => $model->getKey(),
                'type' => $event->type,
                'message' => $event->message,
                'original_data' => $original,
                'changed_data' => $changed,
                'performed_at' => $event->performedAt
            ])
            ->save();
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

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

    /**
     * Returns model data via given method, or invokes the fallback callback
     *
     * @param Model $model
     * @param string $method
     * @param callable $fallback
     *
     * @return array|null
     */
    protected function resolveModelData(Model $model, string $method, callable $fallback): ?array
    {
        if (method_exists($model, $method)) {
            return $model->{$method}();
        }

        return $fallback($model);
    }
}
