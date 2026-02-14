<?php

namespace Aedart\Audit\Formatters;

use Aedart\Audit\Concerns\CallbackReason;
use Aedart\Contracts\Audit\Formatter;
use Aedart\Contracts\Audit\RecordData;
use Aedart\Contracts\Audit\Types;
use Illuminate\Database\Eloquent\Model;

/**
 * Base Audit Trail Record Formatter
 *
 * @see \Aedart\Contracts\Audit\Formatter
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Formatters
 */
abstract class BaseFormatter implements Formatter
{
    use CallbackReason;

    /**
     * The model in question
     *
     * @var Model
     */
    protected Model $model;

    /**
     * Events types to omit attribute changes for
     *
     * @var string[]
     */
    protected array $omitForTypes = [
        Types::DELETED,
        Types::FORCE_DELETED,
        Types::RESTORED
    ];

    /**
     * The attributes that should be hidden for Audit Trail entries
     *
     * @see defaultHiddenAttributes
     * @see hide
     * @see getHiddenAttributes
     *
     * @var string[]
     */
    protected array|null $hiddenAttributes = null;

    /**
     * Create a new Audit Trail Record Formatter instance
     *
     * @param  Model  $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Resolve the Audit Trail entry message, if possible
     *
     * @param string $type Event type
     *
     * @return string|null
     */
    public function message(string $type): string|null
    {
        $callbackReason = $this->callbackReason();
        if ($callbackReason->exists()) {
            $message = $callbackReason->resolve($this->getModel(), $type);
            return $this->formatMessage($type, $message);
        }

        return null;
    }

    /**
     * Format audit trail message, if one is provided for the change
     *
     * @param  string  $type Event type
     * @param  string|null  $message  [optional]
     *
     * @return string|null
     */
    public function formatMessage(string $type, string|null $message = null): string|null
    {
        // Override this method to customize message.
        return $message;
    }

    /**
     * Returns the original data (attributes) to be saved in Audit Trail entry
     *
     * @param string $type Event type
     *
     * @return array|null
     */
    public function originalData(string $type): array|null
    {
        if ($this->shouldOmitChangesFor($type)) {
            return null;
        }

        return $this->formatOriginal(
            $this->filterData($this->getModel()->getOriginal()),
            $type
        );
    }

    /**
     * Returns the changed data (attributes) to be saved
     * in Audit Trail Entry
     *
     * @param string $type Event type
     *
     * @return array|null
     */
    public function changedData(string $type): array|null
    {
        if ($this->shouldOmitChangesFor($type)) {
            return null;
        }

        // Tip: You can use "getAttributes()", if you wish to store all
        // attributes into the Audit Trail entry.
        // @see \Illuminate\Database\Eloquent\Concerns\HasAttributes::getAttributes
        //
        // By default, we only save the changed (dirty) attributes.

        return $this->formatChanged(
            $this->filterData($this->getModel()->getDirty()),
            $type
        );
    }

    /**
     * Formats the original data (attributes) to be saved in Audit Trail entry
     *
     * @see originalData
     *
     * @param array|null $data The filtered original data (if any)
     * @param string $type Event type
     *
     * @return array|null
     */
    public function formatOriginal(array|null $data, string $type): array|null
    {
        // Override this method to customize formatting of the original data.
        return $data;
    }

    /**
     * Formats the changed data (attributes) to be saved in Audit Trail Entry
     *
     * @see changedData
     *
     * @param array|null $data The filtered changed data (if any)
     * @param string $type Event type
     *
     * @return array|null
     */
    public function formatChanged(array|null $data, string $type): array|null
    {
        // Override this method to customize formatting of the changed data.
        return $data;
    }

    /**
     * Filters data to be recorded in Audit Trail entry
     *
     * @param  array|null  $attributes [optional]
     *
     * @return array|null
     *
     * @see getHiddenAttributes
     * @see \Illuminate\Database\Eloquent\Concerns\HidesAttributes::getHidden
     */
    public function filterData(array|null $attributes = null): array|null
    {
        if (empty($attributes)) {
            return null;
        }

        return collect($attributes)

            // Filter off hidden attributes (for Audit Trail entries)
            ->except($this->getHiddenAttributes())

            // Filter off regular hidden attributes (hidden in model)
            ->except($this->getModel()->getHidden())

            ->toArray();
    }

    /**
     * Reduce original attributes, by excluding attributes that have not been changed.
     *
     * @param array|null $original
     * @param array|null $changed
     *
     * @return array|null
     */
    public function reduceOriginal(array|null $original, array|null $changed): array|null
    {
        if (!empty($original) && !empty($changed)) {
            return $this->pluck(array_keys($changed), $original);
        }

        return $original;
    }

    /**
     * Get attributes that are hidden for Audit Trail entries
     *
     * @return string[]
     */
    public function getHiddenAttributes(): array
    {
        if (!isset($this->hiddenAttributes)) {
            $this->hide(
                $this->defaultHiddenAttributes()
            );
        }

        return $this->hiddenAttributes;
    }

    /**
     * Merge new attributes to be hidden for Audit Trail entries
     *
     * @param  string|string[]|null  $attributes
     *
     * @return self
     */
    public function hide(array|string|null $attributes): static
    {
        $attributes = is_array($attributes)
            ? $attributes
            : func_get_args();

        $this->hiddenAttributes = array_merge(
            $this->hiddenAttributes ?? [],
            $attributes
        );

        return $this;
    }

    /**
     * Set the attributes to be hidden for Audit Trail entries
     *
     * @param  string[]  $attributes
     *
     * @return self
     */
    public function setHidden(array $attributes): static
    {
        $this->hiddenAttributes = $attributes;

        return $this;
    }

    /**
     * Returns default hidden attributes
     *
     * @return string[]
     *
     * @see hide
     */
    public function defaultHiddenAttributes(): array
    {
        return $this->timestampAttributes();
    }

    /**
     * Returns the model timestamp attribute names
     *
     * @return string[]
     */
    public function timestampAttributes(): array
    {
        $model = $this->getModel();

        $attributes = [
            $model->getCreatedAtColumn(),
            $model->getUpdatedAtColumn(),
        ];

        if (method_exists($model, 'getDeletedAtColumn')) {
            $attributes[] = $model->getDeletedAtColumn();
        }

        return $attributes;
    }

    /**
     * Omit changes for given event types
     *
     * @see shouldOmitChangesFor
     *
     * @param  string|string[]  $types
     *
     * @return self
     */
    public function omitChangesFor(string|array $types): static
    {
        if (!is_array($types)) {
            $types = [$types];
        }

        $this->omitForTypes = $types;

        return $this;
    }

    /**
     * Determine if changes (attributes) should be omitted for given event type
     *
     * @param string $type
     *
     * @return bool
     */
    public function shouldOmitChangesFor(string $type): bool
    {
        return in_array($type, $this->omitForTypes);
    }

    /**
     * Plucks items from target that match given keys
     *
     * @param string[] $keys The keys to pluck from target
     * @param array $target
     *
     * @return array
     */
    protected function pluck(array $keys, array $target): array
    {
        return collect($target)
            ->only($keys)
            ->toArray();
    }

    /**
     * Returns new Audit Trail Record Data instance
     *
     * @param  array|null  $original  [optional]
     * @param  array|null  $changed  [optional]
     * @param  string|null  $message  [optional]
     *
     * @return RecordData
     */
    protected function makeRecordData(
        array|null $original = null,
        array|null $changed = null,
        string|null $message = null,
    ): RecordData {
        return new FormattedRecord($original, $changed, $message);
    }
}
