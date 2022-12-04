<?php

namespace Aedart\Http\Api\Resources\Relations;

/**
 * Belongs To Many Relation Reference
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Resources\Relations
 */
class BelongsToMany extends BaseRelationReference
{
    /**
     * Creates a new "belongs to many" relation reference
     *
     * {@inheritDoc}
     */
    public function __construct(mixed $resource, string $relation)
    {
        parent::__construct($resource, $relation);

        // Default formatting is the same as for a "has many" relation reference
        $this->whenLoaded([$this, 'formatMultipleLoadedModels']);
    }
}
