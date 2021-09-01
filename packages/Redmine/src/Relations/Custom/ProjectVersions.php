<?php

namespace Aedart\Redmine\Relations\Custom;

use Aedart\Redmine\Relations\HasMany;
use Aedart\Redmine\Version;

/**
 * Project Versions - custom has many relation
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Relations\Custom
 */
class ProjectVersions extends HasMany
{
    /**
     * @inheritDoc
     */
    public function fetch()
    {
        /** @var string|Version $version */
        $version = $this->related();

        return $version::fetchForProject(
            $this->parent()->id(),
            $this->wrapFilters(),
            $this->getLimit(),
            $this->getOffset(),
            $this->getConnection()
        );
    }
}
