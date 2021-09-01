<?php

namespace Aedart\Redmine\Concerns;

use Aedart\Contracts\Dto;
use Aedart\Redmine\Relations\BelongsTo;

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
     * @param string|Resource $related Class path
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
}
