<?php

namespace Aedart\Audit\Subscribers;

use Aedart\Audit\Events\ModelHasChanged;
use Aedart\Audit\Listeners\RecordAuditTrailEntry;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Audit Trail Event Subscriber
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Audit\Subscribers
 */
class AuditTrailEventSubscriber
{
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
    }
}