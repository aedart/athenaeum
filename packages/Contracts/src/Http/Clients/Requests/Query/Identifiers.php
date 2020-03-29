<?php

namespace Aedart\Contracts\Http\Clients\Requests\Query;

/**
 * Http Query Identifiers
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients\Requests\Query
 */
interface Identifiers
{
    /**
     * Ascending order
     */
    public const ASCENDING = 'asc';

    /**
     * Descending order
     */
    public const DESCENDING = 'desc';

    /**
     * Bindings identifier
     */
    public const BINDINGS = '@:bindings:@';

    /**
     * Type identifier
     */
    public const TYPE = '@:type:@';

    /**
     * Fields identifier
     */
    public const FIELDS = '@:fields:@';

    /**
     * Selects identifier
     */
    public const SELECTS = '@:selects:@';

    /**
     * Regular field selection type identifier
     */
    public const SELECT_TYPE_REGULAR = '@:select_regular:@';

    /**
     * Raw field selection type identifier
     */
    public const SELECT_TYPE_RAW = '@:select_raw:@';
}
