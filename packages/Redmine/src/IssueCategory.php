<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Redmine\Deletable;
use Aedart\Contracts\Redmine\Updatable;
use Aedart\Redmine\Partials\Reference;
use Aedart\Redmine\Relations\BelongsTo;

/**
 * Issue Category Resource
 *
 * @see https://www.redmine.org/projects/redmine/wiki/Rest_IssueCategories
 *
 * @property int $id
 * @property string $name
 * @property Reference $project
 * @property Reference|null $assigned_to
 *
 * @property int $assigned_to_id Property only available or expected when creating or updating resource.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine
 */
class IssueCategory extends RedmineResource implements
    Updatable,
    Deletable
{
    use Concerns\ProjectDependentResource;

    protected array $allowed = [
        'id' => 'int',
        'name' => 'string',
        'project' => Reference::class,
        'assigned_to' => Reference::class,

        // Only when creating or updating
        'assigned_to_id' => 'int'
    ];

    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'issue_categories';
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * The project this issue category belongs to
     *
     * @return BelongsTo<Project>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, $this->project);
    }
}
