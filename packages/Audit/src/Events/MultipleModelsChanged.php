<?php

namespace Aedart\Audit\Events;

use Aedart\Audit\Observers\Concerns;
use Aedart\Contracts\Audit\Types;
use DateTimeInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Support\Carbon;
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
    use Dispatchable;
    use Concerns\ModelAttributes;

    /**
     * The models that have changed
     *
     * @var Collection|Model[]
     */
    public $models;

    /**
     * Unique user identifier that caused change
     *
     * @var string|int|null
     */
    public $user;

    /**
     * Date and time of when the event happened
     *
     * (When user performed action that caused model change)
     *
     * @var DateTimeInterface|Carbon|string
     */
    public $performedAt;

    /**
     * The event type
     *
     * @var string
     */
    public string $type;

    /**
     * Original data (attributes) before change occurred
     *
     * @var array|null
     */
    public ?array $original = null;

    /**
     * Changed data (attributes) after change occurred
     *
     * @var array|null
     */
    public ?array $changed = null;

    /**
     * Eventual user provided message associated with the event
     *
     * @var string|null
     */
    public ?string $message = null;

    /**
     * Creates new "multiple models changed" event instance
     *
     * @param Collection<Model>|Model[] $models The changed models
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
        $models,
        $user,
        string $type = Types::UPDATED,
        ?array $original = null,
        ?array $changed = null,
        ?string $message = null,
        $performedAt = null
    )
    {
        // Resolve models argument
        if (!($models instanceof Collection) && is_iterable($models)) {
            $models = collect($models);
        }

        // Abort if no models are given
        if ($models->isEmpty()) {
            throw new RuntimeException('No models are given. Unable to create "multiple models changed" event');
        }

        $this->models = $models;
        $this->user = optional($user)->getKey();
        $this->type = $type;

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
            ->withOriginalData($original)
            ->withChangedData($changed);

        // Resolve evt. message
        $this->message = $message ?? $this->resolveAuditTrailMessage($model, $type);

        // Resolve performed at...
        $performedAt = $performedAt ?? Carbon::now();
        $this->performedAt = $this->formatDatetime($performedAt);
    }

    /**
     * Set the original data (attributes) before changed occurred
     *
     * @param array|null $data [optional]
     *
     * @return self
     */
    public function withOriginalData(?array $data = null): self
    {
        $this->original = $data;

        return $this;
    }

    /**
     * Set the changed data (attributes) after changed occurred
     *
     * @param array|null $data [optional]
     *
     * @return self
     */
    public function withChangedData(?array $data = null): self
    {
        $this->changed = $data;

        return $this;
    }
}