<?php

namespace Aedart\Http\Api\Resources\Relations;

/**
 * Has Many Relation Reference
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Resources\Relations
 */
class HasMany extends BaseRelationReference
{
    /**
     * Creates a new "has many" relation reference
     *
     * {@inheritDoc}
     */
    public function __construct(mixed $resource, string $relation)
    {
        parent::__construct($resource, $relation);

        // Use default multiple models formatting
        $this->whenLoaded([$this, 'formatMultipleLoadedModels']);
    }
}
