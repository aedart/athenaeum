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
 * @author Alin Eugen Deac <ade@rspsystems.com>
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
        // TODO: This can safely be removed in next major version
        // To ensure that we keep backwards compatibility, we load evt. custom listener that has
        // been specified.
        $recordSingleEntryListener = $this->getConfig()->get('audit-trail.listener', RecordAuditTrailEntry::class);

        // Handle change event for a single model
        $dispatcher->listen(
            ModelHasChanged::class,
            [$recordSingleEntryListener, 'handle']
        );

        // Handle multiple models changed event
        $dispatcher->listen(
            MultipleModelsChanged::class,
            [RecordMultipleAuditTrailEntries::class, 'handle']
        );
    }
}