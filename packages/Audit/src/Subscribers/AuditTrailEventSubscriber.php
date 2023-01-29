<?php

namespace Aedart\Audit\Subscribers;

use Aedart\Audit\Events\ModelHasChanged;
use Aedart\Audit\Events\MultipleModelsChanged;
use Aedart\Audit\Listeners\RecordAuditTrailEntry;
use Aedart\Audit\Listeners\RecordMultipleAuditTrailEntries;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Audit Trail Event Subscriber
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Subscribers
 */
class AuditTrailEventSubscriber
{
    use ConfigTrait;

    /**
     * Register the listeners for the subscriber.
     *
     * @param Dispatcher $dispatcher
     *
     * @return void
     */
    public function subscribe(Dispatcher $dispatcher)
    {
        // Handle change event for a single model
        $dispatcher->listen(
            ModelHasChanged::class,
            [RecordAuditTrailEntry::class, 'handle']
        );

        // Handle multiple models changed event
        $dispatcher->listen(
            MultipleModelsChanged::class,
            [RecordMultipleAuditTrailEntries::class, 'handle']
        );
    }
}
