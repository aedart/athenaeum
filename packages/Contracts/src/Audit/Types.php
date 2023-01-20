<?php


namespace Aedart\Contracts\Audit;

/**
 * Audit Trail Entry Types
 *
 * Contains a few predefined Audit Trail Entry types.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Audit
 */
interface Types
{
    /**
     * Model has been created
     */
    public const CREATED = 'created';

    /**
     * Model has been updated
     */
    public const UPDATED = 'updated';

    /**
     * Model has been deleted
     */
    public const DELETED = 'deleted';

    /**
     * Model has been restored (from soft-deleted state)
     */
    public const RESTORED = 'restored';

    /**
     * Model has been force-deleted
     */
    public const FORCE_DELETED = 'force-deleted';
}
