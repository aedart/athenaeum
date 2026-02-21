<?php

namespace Aedart\Audit\Events\Concerns;

use Aedart\Audit\Observers\Concerns\ModelAttributes;
use Aedart\Contracts\Audit\Types;
use DateTimeInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Support\Carbon;

/**
 * Concerns Event Data for audit trail
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Events\Concerns
 */
trait EventData
{
    use Dispatchable;
    use ModelAttributes;

    /**
     * The event type
     *
     * @var string
     */
    public string $type = Types::UPDATED;

    /**
     * Unique user identifier that caused change
     *
     * @var string|int|null
     */
    public string|int|null $user = null;

    /**
     * Original data (attributes) before change occurred
     *
     * @var array|null
     */
    public array|null $original = null;

    /**
     * Changed data (attributes) after change occurred
     *
     * @var array|null
     */
    public array|null $changed = null;

    /**
     * Eventual user provided message associated with the event
     *
     * @var string|null
     */
    public string|null $message = null;

    /**
     * Date and time of when the event happened
     *
     * (When user performed action that caused model change)
     *
     * @var DateTimeInterface|Carbon|string|null
     */
    public DateTimeInterface|Carbon|string|null $performedAt = null;

    /**
     * Set the event type
     *
     * @param  string  $type  [optional]
     *
     * @return self
     */
    public function type(string $type = Types::UPDATED): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set the user that caused the change
     *
     * **Note**: Method only stores user's primary identifier, when a model
     * is given!
     *
     * @param  Model|Authenticatable|null  $user  [optional]
     *
     * @return static
     */
    public function byUser(Model|Authenticatable|null $user): static
    {
        $this->user = optional($user)->getKey();

        return $this;
    }

    /**
     * Set the original data (attributes) before changed occurred
     *
     * @param array|null $data [optional]
     *
     * @return self
     */
    public function withOriginalData(array|null $data = null): static
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
    public function withChangedData(array|null $data = null): static
    {
        $this->changed = $data;

        return $this;
    }

    /**
     * Set eventual user provided message associated with the event
     *
     * @param  string|null  $message  [optional]
     *
     * @return self
     */
    public function withMessage(string|null $message = null): static
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set Date and time of when the event happened.
     *
     * **Note**: When no date is given, then method will to current date time.
     *
     * @param  DateTimeInterface|Carbon|string|null  $performedAt  [optional]
     *
     * @return self
     */
    public function performedAt(DateTimeInterface|Carbon|string|null $performedAt = null): static
    {
        $performedAt = $performedAt ?? Carbon::now();

        $this->performedAt = $this->formatDatetime(
            Carbon::make($performedAt)
        );

        return $this;
    }
}
