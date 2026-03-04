<?php

namespace Aedart\Properties;

use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

/**
 * Reflections
 *
 * <br />
 *
 * Provides some utility methods for obtaining information about
 * a components properties and their accessibility (in overloading
 * context)
 *
 * @deprecated use {@see \Aedart\Dto\ArrayDto} instead, since v10.x
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Properties
 */
trait Reflections
{
    use Accessibility;

    /**
     * Check if this component has an internal property with the
     * given name and if its accessible for "overloading";
     * if it can be accessed via __get(), __set() methods
     *
     * @see getPropertyAccessibilityLevel()
     *
     * @param string $name Property name
     *
     * @return bool True if property exists and is accessible for "overloading"
     *
     * @throws ReflectionException
     *
     * @deprecated use {@see \Aedart\Dto\ArrayDto} instead, since v10.x
     */
    #[\Deprecated(message: "use \Aedart\Dto\ArrayDto instead", since: "10.x")]
    protected function hasInternalProperty(string $name): bool
    {
        $reflection = new ReflectionClass($this);

        return $reflection->hasProperty($name) && $this->isPropertyAccessible($reflection->getProperty($name));
    }

    /**
     * Get internal property which has the given name
     *
     * <b>Warning</b><br />
     * Method doesn't check accessibility
     *
     * @see hasInternalProperty()
     *
     * @param string $name Property name
     *
     * @return ReflectionProperty The given property
     *
     * @throws ReflectionException
     *
     * @deprecated use {@see \Aedart\Dto\ArrayDto} instead, since v10.x
     */
    #[\Deprecated(message: "use \Aedart\Dto\ArrayDto instead", since: "10.x")]
    protected function getInternalProperty(string $name): ReflectionProperty
    {
        return (new ReflectionClass($this))->getProperty($name);
    }

    /**
     * Check if this component has a method of the given name
     *
     * @param string $name Method name
     *
     * @return bool True if method exists, false if not
     *
     * @throws ReflectionException
     *
     * @deprecated use {@see \Aedart\Dto\ArrayDto} instead, since v10.x
     */
    #[\Deprecated(message: "use \Aedart\Dto\ArrayDto instead", since: "10.x")]
    protected function hasInternalMethod(string $name): bool
    {
        static $methods = [];

        $class = static::class;
        if (isset($methods[$class][$name])) {
            return $methods[$class][$name];
        }

        $hasMethod = (new ReflectionClass($this))->hasMethod($name);
        $methods[$class][$name] = $hasMethod;

        return $hasMethod;
    }
}
