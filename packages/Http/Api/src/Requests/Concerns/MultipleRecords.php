<?php

namespace Aedart\Http\Api\Requests\Concerns;

use Aedart\Validation\Rules\AlphaDashDot;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\ValidationException;

/**
 * Concerns Multiple Records
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests\Concerns
 */
trait MultipleRecords
{
    use RecordExistence;

    /**
     * List of requested target records
     *
     * @var Collection<Model>
     */
    public Collection $records;

    /**
     * List of relations to eager-load for target records
     *
     * @var string[]
     */
    protected array $relations = [];

    /**
     * Relations callback
     *
     * @var callable|null
     */
    protected $relationsCallback = null;

    /**
     * Include "trashed" records or not
     *
     * @var bool
     */
    protected bool $withTrashed = false;

    /**
     * Validation rules for target identifier
     *
     * @var array
     */
    protected array $targetIdentifierRules = [];

    /**
     * Name of column which is used for selecting database records
     *
     * @var string
     */
    protected string $modelKeyName;

    /**
     * Name of property in received request payload that
     * holds identifiers.
     *
     * @var string
     */
    protected string $targetsKey = 'targets';

    /**
     * Sets the type of values that {@see targetsKey()} property accepts
     *
     * @see acceptStringValues
     * @see acceptIntegerValues
     *
     * @return void
     */
    abstract public function configureValuesToAccept(): void;

    /**
     * Determine if user is authorised to see or process the records
     *
     * @param Collection<Model> $records
     *
     * @return bool
     */
    abstract public function authorizeFoundRecords(Collection $records): bool;

    /**
     * Finds and prepares requested target records
     *
     * Method attempts to find and verify records that match given targets.
     * After the records are found, the {@see whenRecordsAreFound()} hook method
     * is invoked.
     *
     * @see findRequestedRecords
     * @see verifyAllRecordsFound
     * @see whenRecordsAreFound
     *
     * @param string[]|int[] $targets List of unique identifiers
     * @param string $model Class path to model to be used
     * @param string|null $targetsKey [optional] Defaults to {@see targetsKey()} when none given
     * @param string|null $modelKey [optional] Defaults to {@see modelKeyName()} when none given
     *
     * @return Collection
     *
     * @throws ValidationException If not all requested targets are found
     * @throws AuthorizationException If authenticated user does not have permission
     *                                to see or process found records.
     */
    public function findAndPrepareRecords(
        array $targets,
        string $model,
        string|null $targetsKey = null,
        string|null $modelKey = null
    ): Collection {
        $targetsKey = $targetsKey ?? $this->targetsKey();
        $modelKey = $modelKey ?? $this->modelKeyName();

        // Find the requested records. Note, we cannot be sure that all requested are
        // found at this stage.
        $found = $this->findRequestedRecords(
            $targets,
            $model,
            $modelKey
        );

        // Ensure that user has permission to see or process the records that
        // are found, regardless if all or only some were found.
        if (!$this->authorizeFoundRecords($found)) {
            $this->failedAuthorization();
        }

        // Verify that all requested records are found, or fail.
        $found = $this->verifyAllRecordsFound(
            $targets,
            $found,
            $modelKey,
            $targetsKey
        );

        // Finally, invoke "post found" hook method and return found records.
        $this->whenRecordsAreFound($found);

        return $this->records = $found;
    }

    /**
     * Hook method for when requested records are found
     *
     * This method is invoked immediately after {@see findRecordOrFail},
     * if a record was found.
     *
     * @param Collection<Model> $records
     *
     * @return void
     */
    public function whenRecordsAreFound(Collection $records): void
    {
        // N/A - Overwrite this method if you need additional prepare or
        // validation logic, immediately after requested records are found.
    }

    /**
     * Find requested targets, using given model
     *
     * @param string[]|int[] $targets Unique list of identifiers
     * @param string $model Class path to model that must be used
     * @param string $key [optional] Unique key in model to match against targets
     * @param array|null $relations [optional] Evt. relations to eager-load. Defaults to {@see with()} set relations
     * @param callable|null $relationsCallback [optional] Evt. relations callback. Defaults to {@see with()} set callback
     *
     * @return Collection<Model>
     */
    public function findRequestedRecords(
        array $targets,
        string $model,
        string $key = 'id',
        array|null $relations = null,
        callable|null $relationsCallback = null
    ): Collection {
        $relations = $relations ?? $this->relations;
        $relationsCallback = $relationsCallback ?? $this->relationsCallback;

        /** @var EloquentBuilder|Builder $query */
        $query = $model::query();

        $query = $this->applySoftDeletes($query, $model);
        $query = $this->applyEagerLoading($query, $relations, $relationsCallback);
        $query = $this->applySearch($query, $key, $targets);

        // Finally, find the requested records...
        return $query->get();
    }

    /**
     * Accepts integer values for {@see targetsKey()} property
     *
     * @param string $key [optional] Name of unique key in model
     *
     * @return self
     */
    public function acceptIntegerValues(string $key = 'id'): static
    {
        $this->targetIdentifierRules = $this->uniqueIntegerValuesRules();
        $this->modelKeyName = $key;

        return $this;
    }

    /**
     * Accepts string values for {@see targetsKey()} property
     *
     * @param string $key [optional] Name of unique key in model
     *
     * @return self
     */
    public function acceptStringValues(string $key = 'slug'): static
    {
        $this->targetIdentifierRules = $this->uniqueStringValuesRules();
        $this->modelKeyName = $key;

        return $this;
    }

    /**
     * Set the relations to be eager-loaded for requested records
     *
     * @param string[]|string $relations
     * @param callable|null $callback
     *
     * @return self
     */
    public function with(array|string $relations, callable|null $callback = null): static
    {
        if (!is_array($relations)) {
            $relations = [ $relations ];
        }

        $this->relations = $relations;
        $this->relationsCallback = $callback;

        return $this;
    }

    /**
     * Validation rules for target identifier
     *
     * @return array
     */
    public function targetIdentifierRules(): array
    {
        if (empty($this->targetIdentifierRules)) {
            $this->acceptIntegerValues();
        }

        return $this->targetIdentifierRules;
    }

    /**
     * Returns name of property in request payload that holds unique identifiers
     *
     * @return string
     */
    public function targetsKey(): string
    {
        return $this->targetsKey;
    }

    /**
     * Returns name of column which is used for selecting database records
     *
     * @return string
     */
    public function modelKeyName(): string
    {
        return $this->modelKeyName;
    }

    /**
     * Returns unique integer values validation rules
     *
     * @return array
     */
    protected function uniqueIntegerValuesRules(): array
    {
        return [
            'required',
            'distinct',
            'integer',
            'gt:0'
        ];
    }

    /**
     * Returns unique string values validation rules
     *
     * @return array
     */
    protected function uniqueStringValuesRules(): array
    {
        return [
            'required',
            'distinct',
            'string',
            new AlphaDashDot(),
        ];
    }

    /**
     * Applies with or without trashed constraints on query
     *
     * @param EloquentBuilder|Builder $query
     * @param string|Model $model
     *
     * @return EloquentBuilder|Builder
     */
    protected function applySoftDeletes(EloquentBuilder|Builder $query, string|Model $model): EloquentBuilder|Builder
    {
        $includeDeletedRecords = $this->withTrashed;
        $supportsSoftDeletes = in_array(SoftDeletes::class, class_uses_recursive($model));

        return match (true) {
            $supportsSoftDeletes && $includeDeletedRecords => $query->withTrashed(),
            $supportsSoftDeletes => $query->withoutTrashed(),
            default => $query
        };
    }

    /**
     * Applies the relations to be eager-loaded for given query
     *
     * @param EloquentBuilder|Builder $query
     * @param string[] $relations [optional]
     * @param callable|null $callback [optional]
     *
     * @return EloquentBuilder|Builder
     */
    protected function applyEagerLoading(EloquentBuilder|Builder $query, array $relations = [], callable|null $callback = null): EloquentBuilder|Builder
    {
        return $query
            ->with($relations, $callback);
    }

    /**
     * Applies "search" constraints for query
     *
     * @param EloquentBuilder|Builder $query
     * @param string $key
     * @param string[]|int[] $targets
     *
     * @return EloquentBuilder|Builder
     */
    protected function applySearch(EloquentBuilder|Builder $query, string $key, array $targets): EloquentBuilder|Builder
    {
        return $query
            ->whereIn($key, $targets);
    }
}
