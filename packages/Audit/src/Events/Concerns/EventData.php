<?php

namespace Aedart\Audit\Events\Concerns;

use Aedart\Audit\Formatters\LegacyRecordFormatter;
use Aedart\Audit\Observers\Concerns\ModelAttributes;
use Aedart\Contracts\Audit\Formatter;
use Aedart\Contracts\Audit\Types;
use DateTimeInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Support\Carbon;
use LogicException;

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
     * Format audit trail record (event data)
     *
     * Method automatically sets this event's original and changed data, as well
     * the event type and eventual message.
     *
     * @param  Model  $model
     * @param  string  $type Event type
     * @param  array|null  $original  [optional] Default's to given model's original data, if none given.
     * @param  array|null  $changed  [optional] Default's to given model's changed data, if none given.
     * @param  string|null  $message  [optional] Eventual provided message associated with the event
     *
     * @return self
     *
     * @see type
     * @see withOriginalData
     * @see withChangedData
     * @see withMessage
     */
    public function format(
        Model $model,
        string $type,
        array|null $original = null,
        array|null $changed = null,
        string|null $message = null,
    ): static {
        $record = $this
            ->resolveRecordFormatter($model)
            ->format($type, $original, $changed, $message);

        return $this
            ->type($type)
            ->withOriginalData($record->original())
            ->withChangedData($record->changed())
            ->withMessage($record->message());
    }

    /**
     * Returns a default audit trail record formatter
     *
     * @return class-string<Formatter>|Formatter
     */
    public function defaultAuditTrailRecordFormatter(): string|Formatter
    {
        // TODO: Replace Legacy Record Formatter with "DefaultRecordFormatter"
        // TODO: @see https://github.com/aedart/athenaeum/issues/245
        return LegacyRecordFormatter::class;
    }

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

        $this->performedAt = $this->formatDatetime($performedAt);

        return $this;
    }

    /**
     * Format the given date time
     *
     * @param DateTimeInterface $date
     *
     * @return string
     */
    protected function formatDatetime(DateTimeInterface $date): string
    {
        return $date->format(DateTimeInterface::RFC3339);
    }

    /**
     * Resolves an Audit Trail Record Formatter for the given model
     *
     * @param  Model  $model
     *
     * @return Formatter
     */
    protected function resolveRecordFormatter(Model $model): Formatter
    {
        $formatter = method_exists($model, 'auditTrailRecordFormatter')
            ? $model->auditTrailRecordFormatter()
            : $this->defaultAuditTrailRecordFormatter();

        if (is_null($formatter)) {
            $formatter = $this->defaultAuditTrailRecordFormatter();
        }

        if (is_string($formatter) && class_exists($formatter)) {
            $formatter = new $formatter($model);
        }

        if (!($formatter instanceof Formatter)) {
            throw new LogicException(sprintf('Unable to resolve Audit Trail Record Formatter for model %s', get_class($model)));
        }

        return $formatter;
    }
}
