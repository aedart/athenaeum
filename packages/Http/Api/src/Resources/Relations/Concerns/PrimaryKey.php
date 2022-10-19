<?php

namespace Aedart\Http\Api\Resources\Relations\Concerns;

use Aedart\Contracts\Database\Models\Sluggable;
use Aedart\Contracts\Http\Api\Resources\Relations\Exceptions\RelationReferenceException;
use Illuminate\Database\Eloquent\Model;

/**
 * Concerns Relation Reference Primary Key
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Resources\Relations\Concerns
 */
trait PrimaryKey
{
    /**
     * Name of related model's primary key
     *
     * @var string|null E.g. id
     */
    protected string|null $primaryKeyName = null;

    /**
     * Display name of related model's primary key
     *
     * @var string|null
     */
    protected string|null $primaryKeyDisplayName = null;

    /**
     * When true, relation's primary key value
     * is returned as is - without further formatting
     *
     * @var bool
     */
    protected bool $mustOutputRawIdentifier = false;

    /**
     * Specify whether loaded relation's raw primary key / identifier must be
     * used as this reference's value or not.
     *
     * **Caution**: _When set to true, only the primary key / identifier is returned. No
     * additional attributes, label, formatting, ...etc are applied or used._
     *
     * @param  bool  $value  [optional]
     *
     * @return self
     */
    public function asRawIdentifier(bool $value = true): static
    {
        $this->mustOutputRawIdentifier = $value;

        return $this;
    }

    /**
     * Determine if relation's raw identifier must be used
     * as this reference's value
     *
     * @return bool
     */
    public function mustReturnRawIdentifier(): bool
    {
        return $this->mustOutputRawIdentifier;
    }

    /**
     * Set name of the key to use as the loaded relation's primary identifier
     *
     * @param  string|null  $name  [optional] E.g. id
     * @param  string|null  $displayName  [optional] See {@see setPrimaryKeyDisplayName}
     *
     * @return self
     */
    public function usePrimaryKey(string|null $name = null, string|null $displayName = null): static
    {
        $this->primaryKeyName = $name;
        $this->setPrimaryKeyDisplayName($displayName);

        return $this;
    }

    /**
     * Returns name of relation's primary key
     *
     * @return string|null
     */
    public function getPrimaryKeyName(): string|null
    {
        return $this->primaryKeyName;
    }

    /**
     * Set name of key to that will show relation's identifier
     *
     * @param  string|null  $name  [optional] E.g. id
     *
     * @return self
     */
    public function setPrimaryKeyDisplayName(string|null $name = null): static
    {
        $this->primaryKeyDisplayName = $name;

        return $this;
    }

    /**
     * Returns name of the key to show relation's identifier
     *
     * @return string|null
     */
    public function getPrimaryKeyDisplayName(): string|null
    {
        return $this->primaryKeyDisplayName;
    }

    /**
     * Obtains identifier value (e.g. id) for given model
     *
     * @param  Model  $model
     * @param  string|null  $key  [optional]
     * @param  static|null  $relationReference  [optional]
     *
     * @return mixed
     *
     * @throws RelationReferenceException
     */
    protected function resolveIdentifier(Model $model, string|null $key = null, $relationReference = null): mixed
    {
        $relationReference = $relationReference ?? $this;

        $key = $key ?? $this->guessPrimaryKeyName($model, $relationReference);

        return $model->{$key};
    }

    /**
     * Guess primary key name for given model
     *
     * @param  Model  $model
     * @param  static|null  $relationReference  [optional]
     *
     * @return string
     *
     * @throws RelationReferenceException
     */
    protected function guessPrimaryKeyName(Model $model, $relationReference = null): string
    {
        $relationReference = $relationReference ?? $this;

        // Given model is expected to have a corresponding Api Resource, which
        // already holds information about which key to use as the model's
        // "primary key", for an Api.
        $resource = $relationReference->findApiResourceOrFail($model, $relationReference);

        return $resource->getResourceKeyName();
    }

    /**
     * Add identifier to output
     *
     * @param  array  $output
     * @param  mixed  $identifier
     * @param  Model  $relation
     * @param  static  $relationReference
     *
     * @return array
     *
     * @throws RelationReferenceException
     */
    protected function addRelatedModelPrimaryKey(
        array $output,
        mixed $identifier,
        Model $relation,
        $relationReference,
    ): array
    {
        // Use specified display name for primary key. But, when none was provided,
        // guess the key name...
        $displayName = $relationReference->getPrimaryKeyDisplayName() ?? $this->guessPrimaryKeyName($relation, $relationReference);

        $output[$displayName] = $identifier;

        return $output;
    }
}