<?php

namespace Aedart\Contracts\Properties;

use ReflectionProperty;

/**
 * Accessibility Levels
 *
 * <br />
 *
 * Defines the property accessibility levels, which can be
 * used to determine if a property is allowed to be accessed
 * or not.
 *
 * @see \ReflectionProperty
 *
 * @deprecated use {@see \ReflectionProperty} instead, since v10.x
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Properties
 */
interface AccessibilityLevels
{
    /**
     * Public level - no 'protected' nor 'private' properties
     * are going to be automatically get / set
     *
     * @deprecated use {@see \ReflectionProperty::IS_PUBLIC} instead, since v10.x
     */
    #[\Deprecated(message: "use \ReflectionProperty::IS_PUBLIC instead", since: "10.x")]
    public const int PUBLIC_LEVEL = ReflectionProperty::IS_PUBLIC;

    /**
     * Protected level - properties that are declared
     * 'protected' can be set / get.
     *
     * @deprecated use {@see \ReflectionProperty::IS_PROTECTED} instead, since v10.x
     */
    #[\Deprecated(message: "use \ReflectionProperty::IS_PROTECTED instead", since: "10.x")]
    public const int PROTECTED_LEVEL = ReflectionProperty::IS_PROTECTED;

    /**
     * Private level - properties that are declared
     * 'protected' or 'private' can be set / get.
     *
     * @deprecated use {@see \ReflectionProperty::IS_PRIVATE} instead, since v10.x
     */
    #[\Deprecated(message: "use \ReflectionProperty::IS_PRIVATE instead", since: "10.x")]
    public const int PRIVATE_LEVEL = ReflectionProperty::IS_PRIVATE;

    /**
     * Levels map, key = level, value = name of level
     *
     * @deprecated will not be available in the next major version, since v10.x
     */
    #[\Deprecated(message: "will not be available in the next major version", since: "10.x")]
    public const array LEVELS = [
        self::PUBLIC_LEVEL => 'public',
        self::PROTECTED_LEVEL => 'protected',
        self::PRIVATE_LEVEL => 'private',
    ];
}
