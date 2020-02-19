<?php

namespace Aedart\Properties;

use Aedart\Contracts\Properties\AccessibilityLevels;
use RangeException;
use ReflectionProperty;

/**
 * Property Accessibility
 *
 * <br />
 *
 * Determine what maximum level of accessibly properties must have,
 * before they can be set or get, using PHP's magic methods; __set(), __get()
 *
 * <br />
 *
 * Methods declared inside this trait are all marked protected, because
 * it should not be allowed to change property accessibility, from an
 * outside scope.
 *
 * <br />
 *
 * By default, properties that are declared 'protected' can be can
 * be "overloaded"
 *
 * <br />
 *
 * <b>Tip</b>
 * If you wish for you 'private' declared properties to be accessible
 * on a given component, then invoke <b>setPropertyAccessibilityLevel(...)</b>
 * in e.g. the __construct() method.
 *
 * @see AccessibilityLevels
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Properties
 */
trait Accessibility
{
    /**
     * The current accessibility level
     *
     * @see AccessibilityLevels
     *
     * @var int
     */
    private ?int $propertyAccessibilityLevel = null;

    /**
     * Set the maximum level of accessibility for allowing properties
     * to be set or get
     *
     * @see AccessibilityLevels
     *
     * @param int $level Property accessibility level
     *
     * @return self
     *
     * @throws RangeException If level is invalid
     */
    protected function setPropertyAccessibilityLevel(int $level)
    {
        if (!$this->isPropertyAccessibilityLevelValid($level)) {
            throw new RangeException(sprintf('Property accessibility level "%s" is invalid', $level));
        }
        $this->propertyAccessibilityLevel = $level;

        return $this;
    }

    /**
     * Get the maximum level of accessibility for allowing properties
     * to be set or get
     *
     * If no accessibility level has been specified, this method will
     * set and return a default level.
     *
     * @see getDefaultPropertyAccessibilityLevel()
     *
     * @return int Property accessibility level
     */
    protected function getPropertyAccessibilityLevel(): int
    {
        if (!isset($this->propertyAccessibilityLevel)) {
            $this->setPropertyAccessibilityLevel($this->getDefaultPropertyAccessibilityLevel());
        }

        return $this->propertyAccessibilityLevel;
    }

    /**
     * Returns a default highest property accessibility level
     *
     * @see AccessibilityLevels
     *
     * @return int Default property accessibility level (<b>protected level</b>)
     */
    protected function getDefaultPropertyAccessibilityLevel(): int
    {
        return AccessibilityLevels::PROTECTED_LEVEL;
    }

    /**
     * Validate the given property accessibility level
     *
     * @see AccessibilityLevels
     *
     * @param int $level Property accessibility level
     *
     * @return bool True if level is valid, false if not
     */
    protected function isPropertyAccessibilityLevelValid(int $level): bool
    {
        if (!isset(AccessibilityLevels::LEVELS[$level])) {
            return false;
        }

        return true;
    }

    /**
     * Check if a given property is accessible; if this component is allowed
     * to use __get() / __set() to read / write the given property
     *
     * <b>Static properties</b><br />
     * Static properties are NOT considered to be accessible, in this
     * default implementation
     *
     * @see getPropertyAccessibilityLevel()
     *
     * @param ReflectionProperty $property The given property in question
     *
     * @return bool True if the given property is accessible, false if not
     */
    protected function isPropertyAccessible(ReflectionProperty $property): bool
    {
        $level = $this->getPropertyAccessibilityLevel();

        if (!$property->isStatic() && $property->getModifiers() <= $level) {
            return true;
        }

        return false;
    }
}
