<?php

namespace Aedart\Audit\Events;

use Aedart\Contracts\Audit\Types;
use DateTimeInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Throwable;

/**
 * Model Has Changed Event
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Audit\Events
 */
class ModelHasChanged
{
    use Concerns\EventData;

    /**
     * Class path of model that was changed
     *
     * @var string
     */
    public string $model;

    /**
     * Model's primary identifier value
     *
     * @var string|int
     */
    public string|int $id;

    /**
     * ModelHasChanged constructor.
     *
     * @param Model $model The model that has changed
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
     *
     * @throws Throwable
     */
    public function __construct(
        Model $model,
        Model|Authenticatable|null $user,
        string $type = Types::UPDATED,
        array|null $original = null,
        array|null $changed = null,
        string|null $message = null,
        DateTimeInterface|Carbon|string|null $performedAt = null
    ) {
        $this->model = $model::class;
        $this->id = $model->getKey();

        // Resolve the original and changed data (attributes). It's important that this is done during
        // event instance creation, because once this event is serialised / unserialised, the
        // "dirty / changed" attributes are lost on given model.
        // Furthermore, we use given original and changed, if provided.
        $original = $original ?? $this->resolveOriginalData($model, $type);
        $changed = $changed ?? $this->resolveChangedData($model, $type);

        // Reduce original attributes, by excluding attributes that have not been changed.
        // This should reduce amount of data stored per entry.
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
