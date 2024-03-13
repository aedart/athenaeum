<?php

namespace Aedart\Audit\Helpers;

use Aedart\Audit\Observers\Concerns\ModelChangedEvents;
use Aedart\Contracts\Audit\Types;
use Aedart\Contracts\Database\Models\Sluggable;
use Aedart\Database\Models\Concerns\Slugs;
use DateTimeInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use LogicException;
use Throwable;

/**
 * Audit Bulk Recorder
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Helpers
 */
class BulkRecorder
{
    use ModelChangedEvents;

    /**
     * Creates a new bulk recorder instance
     *
     * @return static
     */
    public static function make(): static
    {
        return new static();
    }

    /**
     * Records change for records with given identifiers, of the type of model
     *
     * @see dispatch
     *
     * @param string|Model $modelType Model instance or class path
     * @param string[]|int[] $identifiers Primary keys or slugs
     * @param string $type [optional]
     * @param string|null $message [optional]
     * @param array|null $original [optional]
     * @param array|null $changed [optional]
     * @param Model|Authenticatable|null $user [optional]
     * @param DateTimeInterface|Carbon|string|null $performedAt [optional]
     *
     * @return static
     *
     * @throws Throwable
     */
    public static function recordChangedFor(
        string|Model $modelType,
        array $identifiers,
        string $type = Types::UPDATED,
        string|null $message = null,
        array|null $original = null,
        array|null $changed = null,
        Model|Authenticatable|null $user = null,
        DateTimeInterface|Carbon|string|null $performedAt = null
    ): static {
        $recorder = static::make();

        return $recorder::recordModelsChanged(
            models: $recorder->findModels($modelType, $identifiers),
            type: $type,
            message: $message,
            original: $original,
            changed: $changed,
            user: $user,
            performedAt: $performedAt
        );
    }

    /**
     * Record change for given models
     *
     * @see dispatch
     *
     * @param Model[]|Collection<Model> $models
     * @param string $type [optional]
     * @param string|null $message [optional]
     * @param array|null $original [optional]
     * @param array|null $changed [optional]
     * @param Model|Authenticatable|null $user [optional]
     * @param DateTimeInterface|Carbon|string|null $performedAt [optional]
     *
     * @return static
     *
     * @throws Throwable
     */
    public static function recordModelsChanged(
        array|Collection $models,
        string $type = Types::UPDATED,
        string|null $message = null,
        array|null $original = null,
        array|null $changed = null,
        Model|Authenticatable|null $user = null,
        DateTimeInterface|Carbon|string|null $performedAt = null
    ): static {
        return static::make()->dispatch(
            models: $models,
            type: $type,
            message: $message,
            original: $original,
            changed: $changed,
            user: $user,
            performedAt: $performedAt
        );
    }

    /**
     * Prepares given models and dispatches models changed event
     *
     * @see prepareModels
     * @see dispatchMultipleModelsChanged
     *
     * @param Model[]|Collection<Model> $models
     * @param string $type [optional]
     * @param string|null $message [optional]
     * @param array|null $original [optional]
     * @param array|null $changed [optional]
     * @param Model|Authenticatable|null $user [optional]
     * @param DateTimeInterface|Carbon|string|null $performedAt [optional]
     *
     * @return self
     *
     * @throws Throwable
     */
    public function dispatch(
        array|Collection $models,
        string $type = Types::UPDATED,
        string|null $message = null,
        array|null $original = null,
        array|null $changed = null,
        Model|Authenticatable|null $user = null,
        DateTimeInterface|Carbon|string|null $performedAt = null
    ): static {
        return $this->dispatchMultipleModelsChanged(
            models: $this->prepareModels($models),
            type: $type,
            original: $original,
            changed: $changed,
            message: $message,
            user: $user,
            performedAt: $performedAt
        );
    }

    /**
     * Prepare models before being dispatched
     *
     * @param Collection<Model>|Model[] $models
     *
     * @return Collection<Model>
     */
    public function prepareModels(array|Collection $models): Collection
    {
        return $models instanceof Collection
            ? $models
            : collect($models);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Find models of the given type, for given identifiers
     *
     * @param string|Model $model Model instance or class path
     * @param string[]|int[] $identifiers Primary keys or slugs
     *
     * @return Collection<Model> Collection of models with only identifiers (primary key) set
     */
    protected function findModels(string|Model $model, array $identifiers): Collection
    {
        $model = $model instanceof Model
            ? $model
            : new $model();

        $isSluggableModel = $this->isSluggableModel($model);
        $isListOfSlugs = $this->isListOfSlugs($identifiers);

        // In case that slugs are given, then we must query the database to obtain primary keys...
        if ($isSluggableModel && $isListOfSlugs) {
            return $model::withTrashed()
                ->select($model->getKeyName())
                ->whereSlugIn($identifiers)
                ->get();

            // If model is not sluggable, but list of slugs has been given, then abort.
        } elseif (!$isSluggableModel && $isListOfSlugs) {
            throw new LogicException(sprintf('%s is not Sluggable, but list of string identifiers has been provided', $model::class));
        }

        // Otherwise, simply create new model instances and add them to collection
        $result = [];
        foreach ($identifiers as $primaryKey) {
            $result[] = $model
                ->newInstance([], true)
                ->forceFill([
                    $model->getKeyName() => $primaryKey
                ]);
        }

        return collect($result);
    }

    /**
     * Determine if model is sluggable
     *
     * @param Model $model
     *
     * @return bool
     */
    protected function isSluggableModel(Model $model): bool
    {
        if (method_exists($model, 'useSlugAsIdentifier')) {
            return $model->useSlugAsIdentifier();
        }

        // Default to determine using if slugs should be used or not...
        return $model instanceof Sluggable || in_array(Slugs::class, class_uses_recursive($model));
    }

    /**
     * Determine if all identifiers are "slugs"
     *
     * @param array $identifiers
     *
     * @return bool
     */
    protected function isListOfSlugs(array $identifiers): bool
    {
        foreach ($identifiers as $id) {
            if (!is_string($id)) {
                return false;
            }
        }

        return true;
    }
}
