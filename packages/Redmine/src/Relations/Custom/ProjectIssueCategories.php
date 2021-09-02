<?php

namespace Aedart\Redmine\Relations\Custom;

use Aedart\Redmine\IssueCategory;
use Aedart\Redmine\Relations\HasMany;

/**
 * Project Issue Categories - custom has many relation
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Relations\Custom
 */
class ProjectIssueCategories extends HasMany
{
    /**
     * @inheritDoc
     */
    public function fetch()
    {
        /** @var string|IssueCategory $category */
        $category = $this->related();

        return $category::fetchForProject(
            $this->parent()->id(),
            $this->wrapFilters(),
            $this->getLimit(),
            $this->getOffset(),
            $this->getConnection()
        );
    }
}
