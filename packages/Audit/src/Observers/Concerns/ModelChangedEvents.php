<?php


namespace Aedart\Audit\Observers\Concerns;

use Aedart\Audit\Events\ModelHasChanged;
use Aedart\Support\Helpers\Auth\AuthTrait;
use Aedart\Support\Helpers\Events\DispatcherTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Concerns Model Changed Events
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Audit\Observers\Concerns
 */
trait ModelChangedEvents
{
    use AuthTrait;
    use DispatcherTrait;

    /**
     * Dispatches model has changed event
     *
     * @param Model $model The model that has changed
     * @param string $type [optional] The event type
     * @param string|null $message [optional] Eventual user provided message associated with the event.
     *                              Defaults to model's Audit Trail Message, if available
     *
     * @return self
     */
    public function dispatchModelChanged(Model $model, string $type, ?string $message = null)
    {
        // Abort if model does not wish to record it's next change
        if (method_exists($model, 'mustRecordNextChange') && !$model->mustRecordNextChange()) {
            return $this;
        }

        $event = $this->makeHasChangedEvent($model, $type, $message);

        $this->getDispatcher()->dispatch($event);

        return $this;
    }

    /**
     * Creates a new "model has changed" event
     *
     * @param Model $model The model that has changed
     * @param string $type [optional] The event type
     * @param string|null $message [optional] Eventual user provided message associated with the event.
     *                              Defaults to model's Audit Trail Message, if available
     *
     * @return ModelHasChanged
     */
    public function makeHasChangedEvent(Model $model, string $type, ?string $message = null): ModelHasChanged
    {
        // Create new model has changed event
        return new ModelHasChanged(
            $model,
            $this->user(),
            $type,
            null, // Original data is resolved from model in this context
            null, // Changed data is resolved from model in this context
            $message
        );
    }

    /**
     * Returns the currently authenticated user
     *
     * @return Authenticatable|null
     */
    public function user(): ?Authenticatable
    {
        return $this->getAuth()->user();
    }
}
