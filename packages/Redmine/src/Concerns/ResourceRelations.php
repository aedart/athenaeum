<?php

namespace Aedart\Redmine\Concerns;

use Aedart\Contracts\Dto;
use Aedart\Contracts\Redmine\PaginatedResults;
use Aedart\Redmine\Relations\BelongsTo;
use Aedart\Redmine\Relations\HasMany;

/**
 * Concerns Resource Relations
 *
 * @template T
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Concerns
 */
trait ResourceRelations
{
    /**
     * Returns new belongs to relation
     *
     * @param string|Resource $related Class path to related resource
     * @param Dto|null $reference [optional] Reference Dto in parent resource that holds foreign key to
     *                                       related resource
     *
     * @param string $key [optional] Name of key / property in reference that holds
     *                               the foreign key value
     *
     * @return BelongsTo<T>
     */
    public function belongsTo($related, ?Dto $reference = null, string $key = 'id'): BelongsTo
    {
        return new BelongsTo($this, $related, $reference, $key);
    }

    /**
     * Returns new has many relation
     *
     * @param string|Resource $related Class path to related resource
     * @param string|null $filterKey [optional]
     *
     * @return HasMany<PaginatedResults<T>|array<T>>
     */
    public function hasMany($related, ?string $filterKey = null): HasMany
    {
        return new HasMany($this, $related, $filterKey);
    }
}
