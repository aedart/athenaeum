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
    public const BOOL_TYPE = 'bool';

    /**
     * Integer Type
     */
    public const INT_TYPE = 'int';

    /**
     * Float (double) Type
     */
    public const FLOAT_TYPE = 'float';

    /**
     * String Type
     */
    public const STRING_TYPE = 'string';

    /**
     * Scalar Types
     */
    public const SCALAR_TYPES = [
        self::BOOL_TYPE,
        self::INT_TYPE,
        self::FLOAT_TYPE,
        self::STRING_TYPE
    ];

    // -------------------------------------------------------------- //

    /**
     * Array Type
     */
    public const ARRAY_TYPE = 'array';

    /**
     * Object Type
     */
    public const OBJECT_TYPE = 'object';

    /**
     * Callable Type
     */
    public const CALLABLE_TYPE = 'callable';

    /**
     * Iterable Type
     */
    public const ITERABLE_TYPE = 'iterable';

    /**
     * Compound Types
     */
    public const COMPOUND_TYPES = [
        self::ARRAY_TYPE,
        self::OBJECT_TYPE,
        self::CALLABLE_TYPE,
        self::ITERABLE_TYPE
    ];

    // -------------------------------------------------------------- //

    /**
     * Resource Type
     */
    public const RESOURCE_TYPE = 'resource';

    /**
     * Null Type
     */
    public const NULL_TYPE = 'null';

    /**
     * Special Types
     */
    public const SPECIAL_TYPES = [
        self::RESOURCE_TYPE,
        self::NULL_TYPE
    ];

    // -------------------------------------------------------------- //

    /**
     * Mixed type
     */
    public const MIXED_TYPE = 'mixed';

    /**
     * Pseudo types
     */
    public const PSEUDO_TYPES = [
        self::MIXED_TYPE
    ];

    // -------------------------------------------------------------- //

    /**
     * Date Time type
     */
    public const DATE_TIME_TYPE = '\DateTimeInterface';
}
