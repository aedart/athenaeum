<?php

namespace Aedart\Audit\Events;

use Aedart\Audit\Observers\Concerns;
use Aedart\Contracts\Audit\Types;
use Aedart\Utils\Helpers\Invoker;
use DateTimeInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
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
    use Dispatchable;
    use SerializesModels;
    use Concerns\ModelAttributes;

    /**
     * The model that has been changed
     *
     * @var Model
     */
    public Model $model;

    /**
     * The user that caused the change
     *
     * @var Model|Authenticatable|null
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
        $user,
        string $type = Types::UPDATED,
        ?array $original = null,
        ?array $changed = null,
        ?string $message = null,
        $performedAt = null
    ) {
        $this->model = $model;
        $this->user = $user;
        $this->type = $type;

        // Resolve the original and changed data (attributes). It's important that this is done during
        // event instance creation, because once this event is serialised / unserialised, the
        // "dirty / changed" attributes are lost on given model.
        // Furthermore, we use given original and changed, if provided.
        $original = $original ?? $this->resolveOriginalData($model, $type);
        $changed = $changed ?? $this->resolveChangedData($model, $type);

        // Reduce original attributes, by excluding attributes that have not been changed.
        // This should reduce amount of data stored per entry.
        $original = $this->reduceOriginal($original, $changed);

        // Finally, set the original and changed attributes.
        $this
            ->withOriginalData($original)
            ->withChangedData($changed);

        // Resolve evt. message
        $this->message = $message ?? $this->resolveAuditTrailMessage($model, $type);

        // Resolve performed at...
        $this->performedAt = $this->resolvePerformedAtUsing($model, $performedAt);
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
