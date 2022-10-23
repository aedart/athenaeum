<?php

namespace Aedart\Http\Api\Resources\Relations\Concerns;

use Aedart\Contracts\Http\Api\Resources\Relations\Exceptions\RelationReferenceException as RelationReferenceExceptionInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Concerns Relation Reference Resource Type
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Resources\Relations\Concerns
 */
trait ResourceType
{
    /**
     * When true, relation's corresponding Api Resource type
     * is displayed
     *
     * @var bool
     */
    protected bool $showResourceType = false;

    /**
     * When true, the plural form of relation's Api
     * Resource type is shown
     *
     * @var bool
     */
    protected bool $usePluralResourceTypeName = false;

    /**
     * Display name of the key to show relation's Api
     * Resource type
     *
     * @var string
     */
    protected string $resourceTypeDisplayName = 'type';

    /**
     * Set whether relation's corresponding Api Resource type
     * should be included in reference's value output, or not
     *
     * @param  bool  $show  [optional]
     * @param  bool  $plural  [optional] When true, the plural form of Api Resource's
     *                         type is displayed
     * @return self
     */
    public function withResourceType(bool $show = true, bool $plural = false): static
    {
        $this->showResourceType = $show;
        $this->usePluralResourceTypeName = $plural;

        return $this;
    }

    /**
     * Ensures that relation's corresponding Api Resource type is not
     * part of this reference's value output
     *
     * @return self
     */
    public function withoutResourceType(): static
    {
        return $this->withResourceType(false);
    }

    /**
     * Determine if relation's corresponding Api Resource type
     * should be included in reference's value output
     *
     * @return bool
     */
    public function mustShowResourceType(): bool
    {
        return $this->showResourceType;
    }

    /**
     * Determine if plural form of Api Resource's type must be shown
     * instead of default singular form
     *
     * @return bool
     */
    public function mustUsePluralResourceType(): bool
    {
        return $this->usePluralResourceTypeName;
    }

    /**
     * Set the display name of the key to show relation's Api
     * Resource type
     *
     * @param  string  $name  [optional]
     *
     * @return self
     */
    public function setResourceTypeDisplayName(string $name = 'type'): static
    {
        $this->resourceTypeDisplayName = $name;

        return $this;
    }

    /**
     * Returns display name of the key to show relation's Api
     * Resource type
     *
     * @return string
     */
    public function getResourceTypeDisplayName(): string
    {
        return $this->resourceTypeDisplayName;
    }

    /**
     * Adds resource type in output, if needed
     *
     * @param  array  $output
     * @param  Model  $relation
     * @param  static  $relationReference
     *
     * @return array
     *
     * @throws RelationReferenceExceptionInterface
     */
    protected function addResourceType(array $output, Model $relation, $relationReference): array
    {
        if (!$relationReference->mustShowResourceType()) {
            return $output;
        }

        // Obtain Api Resource instance that matches the related model
        $resource = $this->findApiResourceOrFail($relation, $relationReference);

        // Resolve plural or singular type name
        $type = ($relationReference->mustUsePluralResourceType())
            ? $resource->pluralType()
            : $resource->type();

        // Finally, add resource type to output
        $displayName = $relationReference->getResourceTypeDisplayName();
        $output[$displayName] = $type;

        return $output;
    }
}