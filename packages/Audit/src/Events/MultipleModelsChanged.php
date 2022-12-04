<?php

namespace Aedart\Audit\Events;

use Aedart\Contracts\Audit\Types;
use DateTimeInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use RuntimeException;
use Throwable;

/**
 * Multiple Models Changed Event
 *
 * Intended to be dispatched when multiple models have the same
 * type of change performed, e.g.:
 * - all records have an attribute set to specific value.
 * - all records are soft-deleted.
 * - all records are recovered.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Audit\Events
 */
class MultipleModelsChanged
{
    use Concerns\EventData;

    /**
     * The models that have changed
     *
     * @var Collection|Model[]
     */
    public Collection|array $models;

    /**
     * Creates new "multiple models changed" event instance
     *
     * @param  Collection<Model>|Model[]  $models The changed models
     * @param Model|Authenticatable|null $user The user that caused the change
     * @param string $type [optional] The event type
     * @param array|null $original [optional] Original data (attributes) before change occurred.
     *                                        Default's to given model's original data, if none given.
     * @param array|null $changed [optional] Changed data (attributes) after change occurred.
     *                                        Default's to given model's changed data, if none given.
     * @param string|null $message [optional] Eventual user provided message associated with the event
     * @param DateTimeInterface|Carbon|string|null $performedAt [optional] Date and time of when the event happened.
     *                                                          Defaults to model's "updated at" value, if available,
     *                                                          If not, then current date time is used.
     * @throws Throwable
     */
    public function __construct(
        array|Collection $models,
        Model|Authenticatable|null $user,
        string $type = Types::UPDATED,
        array|null $original = null,
        array|null $changed = null,
        string|null $message = null,
        DateTimeInterface|Carbon|string|null $performedAt = null
    ) {
        // Resolve models argument
        if (!($models instanceof Collection)) {
            $models = collect($models);
        }

        // Abort if no models are given
        if ($models->isEmpty()) {
            throw new RuntimeException('No models are given. Unable to create "multiple models changed" event');
        }

        $this->models = $models;

        // Resolve the original and changed data (attributes). Must be done before
        // event is serialised. Here, we assume that the same kind of change is made
        // for all models. So we obtain the first model and use to determine original
        // and changed data, if nothing specific is given.

        /** @var Model $model */
        $model = $models->first();
        $original = $original ?? $this->resolveOriginalData($model, $type);
        $changed = $changed ?? $this->resolveChangedData($model, $type);

        // Reduce original attributes, and set original and changed
        $original = $this->reduceOriginal($original, $changed);

        $this
            ->byUser($user)
            ->type($type)
            ->withOriginalData($original)
            ->withChangedData($changed)
            ->withMessage($message ?? $this->resolveAuditTrailMessage($model, $type))
            ->performedAt($performedAt);
    }
}
