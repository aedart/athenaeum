<?php

namespace Aedart\Audit\Events;

use Aedart\Contracts\Audit\Types;
use DateTimeInterface;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

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

    /**
     * The model that has been changed
     *
     * @var Model
     */
    public Model $model;

    /**
     * The user that caused the change
     *
     * @var Model|Authenticatable|\App\Models\User|null
     */
    public $user;

    /**
     * Date and time of when the event happened
     *
     * (When user performed action that caused model change)
     *
     * @var Carbon
     */
    public Carbon $performedAt;

    /**
     * The event type
     *
     * @var string
     */
    public string $type;

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
     * @param Model|Authenticatable|\App\Models\User|null $user The user that caused the change
     * @param string $type [optional] The event type
     * @param DateTimeInterface|null $performedAt [optional] Date and time of when the event happened
     * @param string|null $message [optional] Eventual user provided message associated with the event
     */
    public function __construct(
        Model $model,
        $user,
        string $type = Types::UPDATED,
        ?DateTimeInterface $performedAt = null,
        ?string $message = null
    ) {
        $this->model = $model;
        $this->user = $user;
        $this->type = $type;
        $this->message = $message;

        $this->performedAt = (isset($performedAt))
            ? Carbon::make($performedAt)
            : Carbon::now();
    }
}