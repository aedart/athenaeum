<?php

namespace Aedart\Http\Api\Resources\Relations;

/**
 * Belongs To Relation Reference
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Resources\Relations
 */
class BelongsTo extends BaseRelationReference
{
    /**
     * Creates a new "belongs to" relation reference
     *
     * {@inheritDoc}
     */
    public function __construct(mixed $resource, string $relation)
    {
        parent::__construct($resource, $relation);

        // Set the default formatting for a single related model...
        $this->whenLoaded([$this, 'formatSingleLoadedModel']);
    }
}