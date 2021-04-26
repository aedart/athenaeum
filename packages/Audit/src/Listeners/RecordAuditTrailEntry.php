<?php


namespace Aedart\Audit\Listeners;

use Aedart\Audit\Events\ModelHasChanged;
use Aedart\Audit\Models\Concerns;
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
    use Concerns\AuditTrailConfiguration;

    /**
     * The number of times the queued listener may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Handle listener after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

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
        $original = $this->resolveModelData($model, 'originalData', function(Model $model) {
            return $model->getOriginal();
        });

        $changed = $this->resolveModelData($model, 'changedData', function(Model $model) {
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