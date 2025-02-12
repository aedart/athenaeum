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
    public const string ASCENDING = 'asc';

    /**
     * Descending order
     */
    public const string DESCENDING = 'desc';

    /**
     * Datetime date-format identifier
     */
    public const string DATETIME_FORMAT = 'datetime_format';

    /**
     * Date date-format identifier
     */
    public const string DATE_FORMAT = 'date_format';

    /**
     * Year date-format identifier
     */
    public const string YEAR_FORMAT = 'year_format';

    /**
     * Month date-format identifier
     */
    public const string MONTH_FORMAT = 'month_format';

    /**
     * Day date-format identifier
     */
    public const string DAY_FORMAT = 'day_format';

    /**
     * Time date-format identifier
     */
    public const string TIME_FORMAT = 'time_format';

    /**
     * Http query parameter separator identifier
     */
    public const string PARAMETER_SEPARATOR = 'parameter_separator';

    /**
     * "And where" conjunction separator identifier
     */
    public const string AND_SEPARATOR = 'and_separator';

    /**
     * "Or where" conjunction separator identifier
     */
    public const string OR_SEPARATOR = 'or_separator';

    /**
     * Bindings identifier
     */
    public const string BINDINGS = '@:bindings:@';

    /**
     * Type identifier
     */
    public const string TYPE = '@:type:@';

    /**
     * Default equals identifier
     */
    public const string EQUALS = '=';

    /**
     * Field identifier
     */
    public const string FIELD = '@:field:@';

    /**
     * Fields identifier
     */
    public const string FIELDS = '@:fields:@';

    /**
     * Value identifier
     */
    public const string VALUE = '@:value:@';

    /**
     * Raw expression identifier
     */
    public const string RAW = '@:raw:@';

    /**
     * Expression identifier
     */
    public const string EXPRESSION = '@:expression:@';

    /**
     * Selects identifier
     */
    public const string SELECTS = '@:selects:@';

    /**
     * Regular field selection type identifier
     */
    public const string SELECT_TYPE_REGULAR = '@:select_regular:@';

    /**
     * Raw field selection type identifier
     */
    public const string SELECT_TYPE_RAW = '@:select_raw:@';

    /**
     * Wheres (conditions) identifier
     */
    public const string WHERES = '@:wheres:@';

    /**
     * Regular where type identifier
     */
    public const string WHERE_TYPE_REGULAR = '@:where_regular:@';

    /**
     * Raw where type identifier
     */
    public const string WHERE_TYPE_RAW = '@:where_raw:@';

    /**
     * Conjunction identifier
     */
    public const string CONJUNCTION = '@:conjunction:@';

    /**
     * "And" conjunction identifier
     */
    public const string AND_CONJUNCTION = '@:and:@';

    /**
     * "Or" conjunction identifier
     */
    public const string OR_CONJUNCTION = '@:or:@';

    /**
     * Operator identifier
     */
    public const string OPERATOR = '@:operator:@';

    /**
     * Includes identifier
     */
    public const string INCLUDES = '@:includes:@';

    /**
     * Limit identifier
     */
    public const string LIMIT = '@:limit:@';

    /**
     * Offset identifier
     */
    public const string OFFSET = '@:offset:@';

    /**
     * Page number identifier
     */
    public const string PAGE_NUMBER = '@:page_number:@';

    /**
     * Page size identifier
     */
    public const string PAGE_SIZE = '@:page_size:@';

    /**
     * Sorting order criteria identifier
     */
    public const string ORDER_BY = '@:order_by:@';

    /**
     * Sorting order direction identifier
     */
    public const string DIRECTION = '@:direction:@';
}
