<?php

namespace Aedart\Audit\Listeners;

use Aedart\Audit\Events\MultipleModelsChanged;
use Illuminate\Support\Carbon;
use JsonException;
use Throwable;

/**
 * Record Multiple Audit Trail Entries - Event Listener
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Listeners
 */
class RecordMultipleAuditTrailEntries extends RecordsEntries
{
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
    protected function prepareEntries(MultipleModelsChanged $event, int|null $userId = null): array
    {
        $output = [];

        // Obtain first model from collection. We need this to
        // determine the class path.
        $first = $event->models->first();
        $type = $first::class;

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
}
