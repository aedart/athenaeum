<?php


namespace Aedart\Audit\Observers\Concerns;

use Aedart\Audit\Events\ModelHasChanged;
use Aedart\Audit\Events\MultipleModelsChanged;
use Aedart\Support\Helpers\Auth\AuthTrait;
use Aedart\Support\Helpers\Events\DispatcherTrait;
use DateTimeInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Throwable;

/**
 * Concerns Model Changed Events
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Observers\Concerns
 */
trait ModelChangedEvents
{
    use AuthTrait;
    use DispatcherTrait;

    /**
     * Dispatches model has changed event
     *
     * @param  Model  $model  The model that has changed
     * @param  string  $type  [optional] The event type
     * @param array|null $original [optional] Original data (attributes) before change occurred.
     *                                        Default's to given model's original data, if none given.
     * @param array|null $changed [optional] Changed data (attributes) after change occurred.
     *                                        Default's to given model's changed data, if none given.
     * @param  string|null  $message  [optional] Eventual user provided message associated with the event.
     *                              Defaults to model's Audit Trail Message, if available
     * @param Model|Authenticatable|null $user [optional] The user that caused the change.
     *                                         Defaults to current authenticated user.
     * @param DateTimeInterface|Carbon|string|null $performedAt [optional] Date and time of when the event happened.
     *                                                          Defaults to model's "updated at" value, if available,
     *                                                          If not, then current date time is used.
     *
     * @return self
     *
     * @throws Throwable
     */
    public function dispatchModelChanged(
        Model $model,
        string $type,
        array|null $original = null,
        array|null $changed = null,
        string|null $message = null,
        Model|Authenticatable|null $user = null,
        DateTimeInterface|Carbon|string|null $performedAt = null
    ): static {
        // Abort if model does not wish to record its next change
        if (method_exists($model, 'mustRecordNextChange') && !$model->mustRecordNextChange()) {
            return $this;
        }

        $event = $this->makeHasChangedEvent(
            model: $model,
            type: $type,
            original: $original,
            changed: $changed,
            message: $message,
            user: $user,
            performedAt: $performedAt
        );

        $this->getDispatcher()->dispatch($event);

        return $this;
    }

    /**
     * Dispatches multiple models changed event
     *
     * @param  Collection<Model>|Model[]  $models The changed models
     * @param string $type [optional] The event type
     * @param array|null $original [optional] Original data (attributes) before change occurred.
     *                                        Default's to given model's original data, if none given.
     * @param array|null $changed [optional] Changed data (attributes) after change occurred.
     *                                        Default's to given model's changed data, if none given.
     * @param string|null $message [optional] Eventual user provided message associated with the event
     * @param Model|Authenticatable|null $user [optional] The user that caused the change.
     *                                         Defaults to current authenticated user.
     * @param DateTimeInterface|Carbon|string|null $performedAt [optional] Date and time of when the event happened.
     *                                                          Defaults to model's "updated at" value, if available,
     *                                                          If not, then current date time is used.
     *
     * @return self
     *
     * @throws Throwable
     */
    public function dispatchMultipleModelsChanged(
        array|Collection $models,
        string $type,
        array|null $original = null,
        array|null $changed = null,
        string|null $message = null,
        Model|Authenticatable|null $user = null,
        DateTimeInterface|Carbon|string|null $performedAt = null
    ): static {
        // Resolve models argument
        if (!($models instanceof Collection)) {
            $models = collect($models);
        }

        // Filter off models that are marked as "skipped" for next recording...
        $models = $models->filter(function ($model) {
            if (method_exists($model, 'mustRecordNextChange')) {
                return $model->mustRecordNextChange();
            }

            return true;
        });

        // Abort if no models changed...
        if ($models->isEmpty()) {
            return $this;
        }

        $event = $this->makeMultipleModelsChangedEvent(
            models: $models,
            type: $type,
            original: $original,
            changed: $changed,
            message: $message,
            user: $user,
            performedAt: $performedAt
        );

        $this->getDispatcher()->dispatch($event);

        return $this;
    }

    /**
     * Creates a new "model has changed" event
     *
     * @param  Model  $model  The model that has changed
     * @param  string  $type  [optional] The event type
     * @param  array|null  $original  [optional] Original data (attributes) before change occurred.
     *                                        Default's to given model's original data, if none given.
     * @param  array|null  $changed  [optional] Changed data (attributes) after change occurred.
     *                                        Default's to given model's changed data, if none given.
     * @param  string|null  $message  [optional] Eventual user provided message associated with the event.
     *                              Defaults to model's Audit Trail Message, if available
     * @param Model|Authenticatable|null $user [optional] The user that caused the change.
     *                                         Defaults to current authenticated user.
     * @param DateTimeInterface|Carbon|string|null $performedAt [optional] Date and time of when the event happened.
     *                                                          Defaults to model's "updated at" value, if available,
     *                                                          If not, then current date time is used.
     *
     * @return ModelHasChanged
     *
     * @throws Throwable
     */
    public function makeHasChangedEvent(
        Model $model,
        string $type,
        array|null $original = null,
        array|null $changed = null,
        string|null $message = null,
        Model|Authenticatable|null $user = null,
        DateTimeInterface|Carbon|string|null $performedAt = null
    ): ModelHasChanged {
        // Create new model has changed event
        return new ModelHasChanged(
            model: $model,
            user: $user ?? $this->user(),
            type: $type,
            original: $original,
            changed: $changed,
            message: $message,
            performedAt: $performedAt
        );
    }

    /**
     * Creates a new "multiple models changed" event
     *
     * @param  Collection<Model>|Model[]  $models  The changed models
     * @param  string  $type  [optional] The event type
     * @param  array|null  $original  [optional] Original data (attributes) before change occurred.
     *                                        Default's to given model's original data, if none given.
     * @param  array|null  $changed  [optional] Changed data (attributes) after change occurred.
     *                                        Default's to given model's changed data, if none given.
     * @param  string|null  $message  [optional] Eventual user provided message associated with the event
     * @param Model|Authenticatable|null $user [optional] The user that caused the change.
     *                                         Defaults to current authenticated user.
     * @param DateTimeInterface|Carbon|string|null $performedAt [optional] Date and time of when the event happened.
     *                                                          Defaults to model's "updated at" value, if available,
     *                                                          If not, then current date time is used.
     *
     * @return MultipleModelsChanged
     *
     * @throws Throwable
     */
    public function makeMultipleModelsChangedEvent(
        array|Collection $models,
        string $type,
        array|null $original = null,
        array|null $changed = null,
        string|null $message = null,
        Model|Authenticatable|null $user = null,
        DateTimeInterface|Carbon|string|null $performedAt = null
    ): MultipleModelsChanged {
        return new MultipleModelsChanged(
            models: $models,
            user: $user ?? $this->user(),
            type: $type,
            original: $original,
            changed: $changed,
            message: $message,
            performedAt: $performedAt
        );
    }

    /**
     * Returns the currently authenticated user
     *
     * @return Authenticatable|null
     */
    public function user(): Authenticatable|null
    {
        return $this->getAuth()->user();
    }
}
