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
     * Default equals identifier
     */
    public const EQUALS = '=';

    /**
     * Field identifier
     */
    public const FIELD = '@:field:@';

    /**
     * Fields identifier
     */
    public const FIELDS = '@:fields:@';

    /**
     * Value identifier
     */
    public const VALUE = '@:value:@';

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

    /**
     * Wheres (conditions) identifier
     */
    public const WHERES = '@:wheres:@';

    /**
     * Regular where type identifier
     */
    public const WHERE_TYPE_REGULAR = '@:where_regular:@';

    /**
     * Raw where type identifier
     */
    public const WHERE_TYPE_RAW = '@:where_raw:@';

    /**
     * Operator identifier
     */
    public const OPERATOR = '@:operator:@';

    /**
     * Includes identifier
     */
    public const INCLUDES = '@:includes:@';

    /**
     * Limit identifier
     */
    public const LIMIT = '@:limit:@';

    /**
     * Offset identifier
     */
    public const OFFSET = '@:offset:@';
}
