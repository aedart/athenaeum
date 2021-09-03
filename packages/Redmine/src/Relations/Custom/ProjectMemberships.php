<?php

namespace Aedart\Redmine\Relations\Custom;

use Aedart\Redmine\ProjectMembership;
use Aedart\Redmine\Relations\HasMany;

/**
 * Project Memberships - custom relation
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Relations\Custom
 */
class ProjectMemberships extends HasMany
{
    /**
     * @inheritDoc
     */
    public function fetch()
    {
        /** @var string|ProjectMembership $membership */
        $membership = $this->related();

        return $membership::fetchForProject(
            $this->parent()->id(),
            $this->wrapFilters(),
            $this->getLimit(),
            $this->getOffset(),
            $this->getConnection()
        );
    }
}
