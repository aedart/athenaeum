<?php

namespace Aedart\Redmine\Relations\Custom;

use Aedart\Redmine\Relations\HasMany;

/**
 * Project Dependent Resources - custom relation
 *
 * @see \Aedart\Redmine\Concerns\ProjectDependentResource
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Relations\Custom
 */
class ProjectDependentResources extends HasMany
{
    /**
     * @inheritDoc
     */
    public function fetch()
    {
        /** @var string|\Aedart\Redmine\Concerns\ProjectDependentResource $resource */
        $resource = $this->related();

        return $resource::fetchForProject(
            $this->parent()->id(),
            $this->wrapFilters(),
            $this->getLimit(),
            $this->getOffset(),
            $this->getConnection()
        );
    }
}
