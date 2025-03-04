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
    public const string CREATED = 'created';

    /**
     * Model has been updated
     */
    public const string UPDATED = 'updated';

    /**
     * Model has been deleted
     */
    public const string DELETED = 'deleted';

    /**
     * Model has been restored (from soft-deleted state)
     */
    public const string RESTORED = 'restored';

    /**
     * Model has been force-deleted
     */
    public const string FORCE_DELETED = 'force-deleted';
}
