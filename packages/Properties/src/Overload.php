<?php

namespace Aedart\Properties;

use Aedart\Properties\Exceptions\UndefinedProperty;
use Aedart\Utils\Helpers\MethodHelper;
use ReflectionException;
use ReflectionProperty;

/**
 * Overload
 *
 * <br />
 *
 * Components using this trait will have their properties overloaded.
 *
 * @link http://php.net/manual/en/language.oop5.overloading.php
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
    public function __get(string $name): mixed
    {
        if (!$this->hasInternalProperty($name)) {
            throw new UndefinedProperty(sprintf('Failed reading Property "%s". It does not exist or is inaccessible', $name));
        }

        return $this->invokeGetter($this->getInternalProperty($name));
    }

    /**
     * Method is run when writing data to inaccessible properties.
     *
     * @param string $name
     * @param mixed $value
     *
     * @return void
     *
     * @throws ReflectionException
     * @throws UndefinedProperty
     */
    public function __set(string $name, mixed $value): void
    {
        if (!$this->hasInternalProperty($name)) {
            throw new UndefinedProperty(sprintf('Failed writing Property "%s". It does not exist or is inaccessible', $name));
        }

        $this->invokeSetter($this->getInternalProperty($name), $value);
    }

    /**
     * Method is triggered by calling isset() or empty() on inaccessible properties.
     *
     * <br />
     *
     * If an undefined property is being checked, using isset or empty, then
     * this method will always return false
     *
     * @param string $name
     *
     * @return bool
     *
     * @throws ReflectionException
     */
    public function __isset(string $name): bool
    {
        if (!$this->hasInternalProperty($name)) {
            return false;
        }

        return isset($this->$name);
    }

    /**
     * Method is invoked when unset() is used on inaccessible properties.
     *
     * @param string $name
     *
     * @throws ReflectionException
     */
    public function __unset(string $name): void
    {
        if (!$this->hasInternalProperty($name)) {
            throw new UndefinedProperty(sprintf('Failed unset of Property "%s". It does not exist or is inaccessible', $name));
        }

        unset($this->$name);
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
    protected function invokeGetter(ReflectionProperty $property): mixed
    {
        $methodName = MethodHelper::makeGetterName($property->getName());
        if ($this->hasInternalMethod($methodName)) {
            return $this->$methodName();
        }

        throw new UndefinedProperty(sprintf(
            'No %s() getter-method available for property "%s"',
            $methodName,
            $property->getName()
        ));
    }

    /**
     * Invoke the given property's setter-method
     *
     * @param ReflectionProperty $property
     * @param mixed $value
     *
     * @return mixed
     *
     * @throws ReflectionException
     * @throws UndefinedProperty
     */
    protected function invokeSetter(ReflectionProperty $property, mixed $value): mixed
    {
        $methodName = MethodHelper::makeSetterName($property->getName());
        if ($this->hasInternalMethod($methodName)) {
            return $this->$methodName($value);
        }

        throw new UndefinedProperty(sprintf(
            'No %s() setter-method available for property "%s"',
            $methodName,
            $property->getName()
        ));
    }
}
