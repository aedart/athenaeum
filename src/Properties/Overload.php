<?php

namespace Aedart\Properties;

use Aedart\Properties\Exceptions\UndefinedProperty;
use Aedart\Utils\Helpers\MethodHelper;
use ReflectionException;
use ReflectionProperty;

/**
 * Overload
 *
 * TODO: Description of this trait
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Properties
 */
trait Overload
{
    use Reflections;

    /*****************************************************************
     * Magic methods
     ****************************************************************/

    /**
     * Method is utilized for reading data from inaccessible properties.
     *
     * @param string $name
     *
     * @return mixed
     *
     * @throws ReflectionException
     * @throws UndefinedProperty
     */
    public function __get(string $name)
    {
        if ($this->hasInternalProperty($name)) {
            return $this->invokeGetter($this->getInternalProperty($name));
        }

        throw new UndefinedProperty(sprintf('Property "%s" does not exist or is inaccessible', $name));
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Invoke and return the given property's getter-method
     *
     * @param ReflectionProperty $property
     *
     * @return mixed
     *
     * @throws ReflectionException
     * @throws UndefinedProperty
     */
    protected function invokeGetter(ReflectionProperty $property)
    {
        $methodName = MethodHelper::makeGetterName($property->getName());
        if ($this->hasInternalMethod($methodName)) {
            return $this->$methodName();
        }

        throw new UndefinedProperty(sprintf(
            'No "%s"() method available for property "%s"', $methodName,
            $property->getName()
        ));
    }
}
