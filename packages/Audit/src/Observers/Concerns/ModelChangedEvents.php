<?php


namespace Aedart\Audit\Observers\Concerns;

use Aedart\Audit\Events\ModelHasChanged;
use Aedart\Audit\Traits\HasAuditTrail;
use Aedart\Support\Helpers\Auth\AuthTrait;
use Aedart\Support\Helpers\Events\DispatcherTrait;
use Carbon\Carbon;
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
        // Resolve evt. message
        $message = $this->resolveAuditTrailMessage($model, $type, $message);

        // Resolve performed at date time
        $performedAt = (!empty($model->update_at))
            ? $model->update_at
            : Carbon::now();

        // Create new model has changed event
        return new ModelHasChanged(
            $model,
            $this->user(),
            $type,
            $performedAt,
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

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Resolve the Audit Trail Message, if possible
     *
     * @param Model $model
     * @param string $type
     * @param string|null $message [optional]
     *
     * @return string|null
     */
    protected function resolveAuditTrailMessage(Model $model, string $type, ?string $message = null): ?string
    {
        if (isset($message)) {
            return $message;
        }

        if (in_array(HasAuditTrail::class, class_uses($model))) {
            return $model->getAuditTrailMessage($type);
        }

        return null;
    }
}