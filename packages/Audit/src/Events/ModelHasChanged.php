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
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Events
 */
class ModelHasChanged
{
    use Concerns\EventData;

    /**
     * Class path of model that was changed
     *
     * @var class-string<Model>
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

        $this
            ->byUser($user)
            ->format(
                model: $model,
                type: $type,
                original: $original,
                changed: $changed,
                message: $message,
            )
            ->performedAt($performedAt);
    }
}
