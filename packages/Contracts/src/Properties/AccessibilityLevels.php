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
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Properties
 */
interface AccessibilityLevels
{
    /**
     * Public level - no 'protected' nor 'private' properties
     * are going to be automatically get / set
     */
    public const int PUBLIC_LEVEL = ReflectionProperty::IS_PUBLIC;

    /**
     * Protected level - properties that are declared
     * 'protected' can be set / get.
     */
    public const int PROTECTED_LEVEL = ReflectionProperty::IS_PROTECTED;

    /**
     * Private level - properties that are declared
     * 'protected' or 'private' can be set / get.
     */
    public const int PRIVATE_LEVEL = ReflectionProperty::IS_PRIVATE;

    /**
     * Levels map, key = level, value = name of level
     */
    public const array LEVELS = [
        self::PUBLIC_LEVEL => 'public',
        self::PROTECTED_LEVEL => 'protected',
        self::PRIVATE_LEVEL => 'private',
    ];
}
