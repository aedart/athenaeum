<?php

namespace Aedart\Http\Api\Resources\Relations;

/**
 * Has One Relation Reference
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Resources\Relations
 */
class HasOne extends BaseRelationReference
{
    /**
     * Creates a new "has one" relation reference
     *
     * {@inheritDoc}
     */
    public function __construct(mixed $resource, string $relation)
    {
        parent::__construct($resource, $relation);

        // Default formatting is the same as for a "belongs to" relation reference
        $this->whenLoaded([$this, 'formatSingleLoadedModel']);
    }
}