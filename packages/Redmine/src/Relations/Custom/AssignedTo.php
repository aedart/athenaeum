<?php

namespace Aedart\Redmine\Relations\Custom;

use Aedart\Contracts\Dto;
use Aedart\Contracts\Redmine\ApiResource;
use Aedart\Redmine\Exceptions\NotFound;
use Aedart\Redmine\Group;
use Aedart\Redmine\Relations\BelongsTo;
use Aedart\Redmine\Relations\Custom\Exceptions\GroupDoesNotMatch;
use Aedart\Redmine\User;

/**
 * Assigned To - custom relation
 *
 * The issue "assigned_to" field returns either a reference to a user or
 * a group - yet Redmine's API does not tell which is which. The same is
 * true for a project's "default_assignee" field.
 *
 * This custom relation attempt to figure out what kind og reference it is
 * and resolve the user or group resource.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Relations\Custom
 */
class AssignedTo extends BelongsTo
{
    /**
     * AssignedTo
     *
     * @param ApiResource $parent
     * @param Dto|null $reference [optional] Reference Dto in parent resource that holds foreign key to
     *                                       related resource
     *
     * @param string $key [optional] Name of key / property in reference that holds
     *                               the foreign key value
     */
    public function __construct(ApiResource $parent, ?Dto $reference = null, string $key = 'id')
    {
        // First we try the group, because we might be able to match against it's name...
        $related = Group::class;

        parent::__construct($parent, $related, $reference, $key);
    }

    /**
     * @inheritDoc
     */
    public function fetch()
    {
        // This is not very good... but it will have to do.
        // A defect has been reported to Redmine, in hopes of improvement in future versions.
        // @see https://www.redmine.org/issues/35839

        try {
            /** @var Group $group */
            $group = parent::fetch();

            // If the name does not match exactly, then it's NOT a group...
            // NOTE: We can sadly not do the same for a user, because the reference's name is
            // formatted according to Redmine's display settings for showing names. This means
            // that the name might not be comparable at all, depending on style chosen.
            if ($group->name !== $this->getReference()->name) {
                // This exception will be ignored - we just need it to abort and retry with the user
                // resource instead.
                throw new GroupDoesNotMatch('Reference name does not match group name');
            }

            return $group;
        } catch (NotFound | GroupDoesNotMatch $e) {
            // Attempt to find via user resource
            $this->related = User::class;

            // Allow regular failure... if user not found
            return parent::fetch();
        }
    }
}
