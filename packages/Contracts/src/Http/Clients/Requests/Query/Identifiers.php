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
     * Datetime date-format identifier
     */
    public const DATETIME_FORMAT = 'datetime_format';

    /**
     * Date date-format identifier
     */
    public const DATE_FORMAT = 'date_format';

    /**
     * Year date-format identifier
     */
    public const YEAR_FORMAT = 'year_format';

    /**
     * Month date-format identifier
     */
    public const MONTH_FORMAT = 'month_format';

    /**
     * Day date-format identifier
     */
    public const DAY_FORMAT = 'day_format';

    /**
     * Time date-format identifier
     */
    public const TIME_FORMAT = 'time_format';

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
     * Raw expression identifier
     */
    public const RAW = '@:raw:@';

    /**
     * Expression identifier
     */
    public const EXPRESSION = '@:expression:@';

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

    /**
     * Page number identifier
     */
    public const PAGE_NUMBER = '@:page_number:@';

    /**
     * Page size identifier
     */
    public const PAGE_SIZE = '@:page_size:@';

    /**
     * Sorting order criteria identifier
     */
    public const ORDER_BY = '@:order_by:@';

    /**
     * Sorting order direction identifier
     */
    public const DIRECTION = '@:direction:@';
}
