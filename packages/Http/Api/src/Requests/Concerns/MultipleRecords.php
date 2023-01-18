<?php

namespace Aedart\Http\Api\Requests\Concerns;

use Aedart\Validation\Rules\AlphaDashDot;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\ValidationException;
use Throwable;

/**
 * Concerns Multiple Records
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests\Concerns
 */
trait MultipleRecords
{
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
    protected array $with = [];

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
     * Name of integer type primary key
     *
     * @var string
     */
    protected string $integerKeyName = 'id';

    /**
     * Name of string type identifier key
     *
     * @var string
     */
    protected string $stringKeyName = 'slug';

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
     * @param Validator $validator
     * @param string $model Class path to model
     *
     * @return void
     *
     * @throws Throwable
     */
    public function findAndPrepareRecords(Validator $validator, string $model): void
    {
        $key = $this->targetsKey();
        $modelKey = $this->modelKeyName();

        // Obtain the targets...
        $targets = $validator->validated()[$key] ?? [];

        // Find the requested records. Note, we cannot be sure that all requested are
        // found at this stage.
        $found = $this->findRequestedRecords(
            $targets,
            $model,
            $modelKey
        );

        // Verify that all requested records are found, or fail.
        $this->records = $this->verifyAllRecordsFound(
            $targets,
            $found,
            $modelKey,
            $key
        );

        // Ensure that user has permission to see or process requested records
        if (!$this->authorizeFoundRecords($this->records)) {
            $this->failedAuthorization();
        }

        // Finally, invoke "post found" hook method.
        $this->whenRecordsAreFound($this->records);
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
     * @param string[]|int[] $targets
     * @param string $model Class path to model that must be used
     * @param string $key [optional] Name of key to match targets against
     *
     * @return Collection<Model>
     */
    public function findRequestedRecords(
        array $targets,
        string $model,
        string $key = 'id',
    ): Collection {
        /** @var EloquentBuilder|Builder $query */
        $query = $model::query();

        $query = $this->applySoftDeletes($query, $model);
        $query = $this->applySearch($query, $key, $targets);

        // Finally, find the requested records...
        return $query->get();
    }

    /**
     * Verifies that all requested records are found or fails
     *
     * @param string[]|int[] $requested
     * @param Collection<Model> $found
     * @param string $matchKey Name of key to match
     * @param string $targetsKey Name of property in request payload
     *
     * @return Collection<Model>
     *
     * @throws ValidationException
     */
    public function verifyAllRecordsFound(
        array $requested,
        Collection $found,
        string $matchKey,
        string $targetsKey
    ): Collection {
        // When the amount found matches amount requested, then we assume that all were
        // found. Might not be the most correct, but should be fast...
        if ($found->count() === count($requested)) {
            return $found;
        }

        // Otherwise, the difference must be identified and exception thrown.
        $foundValues = $found->pluck($matchKey)->toArray();
        $difference = array_diff($requested, $foundValues);

        $errors = [];
        foreach ($difference as $notFound) {
            $index = array_search($notFound, $requested);
            if ($index === false) {
                $index = $notFound;
            }

            $errors["{$targetsKey}.{$index}"] = $this->makeRecordNotFoundMessage($notFound, $index);
        }

        throw ValidationException::withMessages($errors);
    }

    /**
     * Accepts integer values for {@see targetsKey()} property
     *
     * @return self
     */
    public function acceptIntegerValues(): static
    {
        $this->targetIdentifierRules = $this->integerValueRules();
        $this->modelKeyName = $this->integerKeyName;

        return $this;
    }

    /**
     * Accepts string values for {@see targetsKey()} property
     *
     * @return self
     */
    public function acceptStringValues(): static
    {
        $this->targetIdentifierRules = $this->stringValueRules();
        $this->modelKeyName = $this->stringKeyName;

        return $this;
    }

    /**
     * Validation rules for target identifier
     *
     * @return array
     */
    public function targetIdentifierRules(): array
    {
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
     * Returns "distinct" integer values validation rules
     *
     * @return array
     */
    protected function integerValueRules(): array
    {
        return [
            'required',
            'distinct',
            'integer',
            'gt:0'
        ];
    }

    /**
     * Returns "distinct" string values validation rules
     *
     * @return array
     */
    protected function stringValueRules(): array
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

        if ($supportsSoftDeletes && $includeDeletedRecords) {
            return $query->withTrashed();
        }

        if ($supportsSoftDeletes) {
            return $query->withoutTrashed();
        }

        return $query;
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
        // Overwrite this method, if you require more advanced find records logic.

        return $query
            ->with($this->with)
            ->whereIn($key, $targets);
    }

    /**
     * Returns a "record not found" error message
     *
     * @param string|int $target
     * @param string|int $index
     *
     * @return string
     */
    protected function makeRecordNotFoundMessage(string|int $target, string|int $index): string
    {
        return sprintf('#%s - Target %s does not exist', $index, $target);
    }
}
