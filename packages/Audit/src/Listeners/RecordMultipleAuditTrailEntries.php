<?php

namespace Aedart\Audit\Listeners;

use Aedart\Audit\Events\MultipleModelsChanged;
use Aedart\Audit\Models\Concerns;
use Aedart\Utils\Json;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Carbon;
use JsonException;
use Throwable;

/**
 * Record Multiple Audit Trail Entries - Event Listener
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Audit\Listeners
 */
class RecordMultipleAuditTrailEntries implements ShouldQueue
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
     * RecordMultipleAuditTrailEntries constructor.
     */
    public function __construct()
    {
        $this->afterCommit = true;

        $this->configureQueueSettings();
    }

    /**
     * Records multiple new Audit Trail Entry, based on given
     * "multiple models changed" event
     *
     * @param MultipleModelsChanged $event
     *
     * @return void
     *
     * @throws Throwable
     */
    public function handle(MultipleModelsChanged $event)
    {
        // Resolve user
        $userId = $event->user;
        if (!$this->userExists($userId)) {
            $userId = null;
        }

        $entries = $this->prepareEntries($event, $userId);

        $auditTrail = $this->auditTrailModelInstance();
        $auditTrail->newQuery()
            ->insert($entries);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Prepare audit trail entries to insert
     *
     * @param MultipleModelsChanged $event
     * @param int|null $userId [optional]
     *
     * @return array[]
     *
     * @throws JsonException
     */
    protected function prepareEntries(MultipleModelsChanged $event, ?int $userId = null): array
    {
        $output = [];

        // Obtain first model from collection. We need this to
        // determine the class path.
        $first = $event->models->first();
        $type = get_class($first);

        $original = $this->convertToJson($event->original);
        $changed = $this->convertToJson($event->changed);

        foreach ($event->models as $model) {
            $output[] = [
                'user_id' => $userId,
                'auditable_type' => $type,
                'auditable_id' => $model->getKey(),
                'type' => $event->type,
                'message' => $event->message,
                'original_data' => $original,
                'changed_data' => $changed,
                'created_at' => Carbon::now(),
                'performed_at' => $event->performedAt
            ];
        }

        return $output;
    }

    /**
     * Convert given data to json
     *
     * @param array|null $data [optional]
     *
     * @return string|null
     *
     * @throws JsonException
     */
    protected function convertToJson(?array $data = null): ?string
    {
        if (!isset($data)) {
            return null;
        }

        return Json::encode($data);
    }

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