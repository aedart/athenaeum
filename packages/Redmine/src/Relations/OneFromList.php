<?php

namespace Aedart\Redmine\Relations;

use Aedart\Contracts\Redmine\ApiResource;
use Aedart\Redmine\Exceptions\RelationException;

/**
 * Belongs To One From List - Relation
 *
 * This kind of relation assumes that the related resource is listable and an
 * entire list of resources is returned, from which the desired related resource
 * must be extracted from.
 *
 * One example of such a resource, is the "issue statuses". They can be listed,
 * yet it's not possible to fetch just a single status!
 *
 * @see https://www.redmine.org/projects/redmine/wiki/Rest_IssueStatuses
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Relations
 */
class OneFromList extends BelongsTo
{
    /**
     * @inheritDoc
     */
    public function fetch()
    {
        // Resolve the foreign key value - or fail if no value obtained
        $value = $this->key();
        if (!isset($value)) {
            throw new RelationException('Unable to fetch relation, foreign key could not be resolved or was not specified');
        }

        /** @var string|ApiResource $related */
        $related = $this->related();
        $primaryKeyName = $related::make()->keyName();

        // Fetch the list
        $list = $related::fetchMultiple(
            $this->wrapFilters(), // It's uncertain if at all applicable here...
            100, // Redmine ignores this for resources that only return a predefined list!
            0,
            $this->getConnection()
        );

        // Filter through the found list, match the key
        return $list
            ->results()
            ->where($primaryKeyName, $value)
            ->first();
    }
}
