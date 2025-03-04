<?php

namespace Aedart\Contracts\Utils;

/**
 * PHP Data Types
 *
 * @link http://php.net/manual/en/language.types.intro.php
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Utils
 */
interface DataTypes
{
    /**
     * Boolean Type
     */
    public const string BOOL_TYPE = 'bool';

    /**
     * Integer Type
     */
    public const string INT_TYPE = 'int';

    /**
     * Float (double) Type
     */
    public const string FLOAT_TYPE = 'float';

    /**
     * String Type
     */
    public const string STRING_TYPE = 'string';

    /**
     * Scalar Types
     */
    public const array SCALAR_TYPES = [
        self::BOOL_TYPE,
        self::INT_TYPE,
        self::FLOAT_TYPE,
        self::STRING_TYPE
    ];

    // -------------------------------------------------------------- //

    /**
     * Array Type
     */
    public const string ARRAY_TYPE = 'array';

    /**
     * Object Type
     */
    public const string OBJECT_TYPE = 'object';

    /**
     * Callable Type
     */
    public const string CALLABLE_TYPE = 'callable';

    /**
     * Iterable Type
     */
    public const string ITERABLE_TYPE = 'iterable';

    /**
     * Compound Types
     */
    public const array COMPOUND_TYPES = [
        self::ARRAY_TYPE,
        self::OBJECT_TYPE,
        self::CALLABLE_TYPE,
        self::ITERABLE_TYPE
    ];

    // -------------------------------------------------------------- //

    /**
     * Resource Type
     */
    public const string RESOURCE_TYPE = 'resource';

    /**
     * Null Type
     */
    public const string NULL_TYPE = 'null';

    /**
     * Special Types
     */
    public const array SPECIAL_TYPES = [
        self::RESOURCE_TYPE,
        self::NULL_TYPE
    ];

    // -------------------------------------------------------------- //

    /**
     * Mixed type
     */
    public const string MIXED_TYPE = 'mixed';

    /**
     * Pseudo types
     */
    public const array PSEUDO_TYPES = [
        self::MIXED_TYPE
    ];

    // -------------------------------------------------------------- //

    /**
     * Date Time type
     */
    public const string DATE_TIME_TYPE = '\DateTimeInterface';
}
