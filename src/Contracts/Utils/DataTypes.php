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
    const BOOL_TYPE = 'bool';

    /**
     * Integer Type
     */
    const INT_TYPE = 'int';

    /**
     * Float (double) Type
     */
    const FLOAT_TYPE = 'float';

    /**
     * String Type
     */
    const STRING_TYPE = 'string';

    /**
     * Scalar Types
     */
    const SCALAR_TYPES = [
        self::BOOL_TYPE,
        self::INT_TYPE,
        self::FLOAT_TYPE,
        self::STRING_TYPE
    ];

    // -------------------------------------------------------------- //

    /**
     * Array Type
     */
    const ARRAY_TYPE = 'array';

    /**
     * Object Type
     */
    const OBJECT_TYPE = 'object';

    /**
     * Callable Type
     */
    const CALLABLE_TYPE = 'callable';

    /**
     * Iterable Type
     */
    const ITERABLE_TYPE = 'iterable';

    /**
     * Compound Types
     */
    const COMPOUND_TYPES = [
        self::ARRAY_TYPE,
        self::OBJECT_TYPE,
        self::CALLABLE_TYPE,
        self::ITERABLE_TYPE
    ];

    // -------------------------------------------------------------- //

    /**
     * Resource Type
     */
    const RESOURCE_TYPE = 'resource';

    /**
     * Null Type
     */
    const NULL_TYPE = 'null';

    /**
     * Special Types
     */
    const SPECIAL_TYPES = [
        self::RESOURCE_TYPE,
        self::NULL_TYPE
    ];

    // -------------------------------------------------------------- //

    /**
     * Mixed type
     */
    const MIXED_TYPE = 'mixed';

    /**
     * Pseudo types
     */
    const PSEUDO_TYPES = [
        self::MIXED_TYPE
    ];

    // -------------------------------------------------------------- //

    /**
     * Date Time type
     */
    const DATE_TIME_TYPE = '\DateTimeInterface';
}
