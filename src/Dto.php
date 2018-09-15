<?php

namespace Aedart;

use Aedart\Contracts\Dto as DtoInterface;
use Aedart\Properties\Overload;
use Aedart\Utils\Helpers\MethodHelper;
use Aedart\Utils\Json;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\App;
use JsonSerializable;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use Throwable;

/**
 * Abstract Data Transfer Object
 *
 * <br />
 *
 * This DTO abstraction offers default implementation of the following;
 *
 * <ul>
 *      <li>Overloading of properties, if they have getters and setters defined</li>
 *      <li>Array-accessibility of properties, if properties have getters and setters defined</li>
 *      <li>Population of properties via array</li>
 *      <li>Resolving nested dependencies, via a IoC service container, if one is available</li>
 *      <li>Exportation of properties to an array</li>
 *      <li>Serialization of properties to json</li>
 * </ul>
 *
 * @see \Aedart\Contracts\Dto
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart
 */
abstract class Dto implements DtoInterface
{
    use Overload {
        __set as __setFromOverload;
    }

    /**
     * IoC Service Container
     *
     * @var null|Container
     */
    private $ioc = null;

    /**
     * Dto constructor.
     *
     * @param array $properties
     * @param Container|null $container [optional]
     *
     * @throws Throwable
     */
    public function __construct(array $properties = [], ?Container $container = null)
    {
        $this->ioc = $container;
        $this->populate($properties);
    }

    /**
     * {@inheritdoc}
     *
     * @throws ReflectionException
     * @throws BindingResolutionException
     */
    public function __set(string $name, $value)
    {
        $resolvedValue = $value;

        $methodName = MethodHelper::makeSetterName($name);
        if ($this->hasInternalMethod($methodName)) {
            $resolvedValue = $this->resolveValue($methodName, $value);
        }

        return $this->__setFromOverload($name, $resolvedValue);
    }

    /**
     * {@inheritdoc}
     *
     * @throws ReflectionException
     */
    public function populatableProperties(): array
    {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties();

        $output = [];
        foreach ($properties as $reflectionProperty){
            $name = $reflectionProperty->getName();
            $method = MethodHelper::makeGetterName($name);

            if($this->hasInternalMethod($method)){
                $output[] = $name;
            }
        }
        return $output;
    }

    /**
     * {@inheritdoc}
     */
    public function container(): ?Container
    {
        if( ! isset($this->ioc)){
            $this->ioc = App::getFacadeApplication();
        }

        return $this->ioc;
    }

    /**
     * {@inheritdoc}
     */
    public function populate(array $data = []): void
    {
        foreach ($data as $property => $value){
            $this->__set($property, $value);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws Throwable
     */
    static public function makeNew(array $properties, ?Container $container = null)
    {
        return new static($properties, $container);
    }

    /**
     * {@inheritdoc}
     *
     * @throws Throwable
     * @throws Utils\Exceptions\JsonEncoding
     */
    static public function fromJson(string $json)
    {
        return static::makeNew(Json::decode($json, true));
    }

    /**
     * {@inheritdoc}
     *
     * @throws ReflectionException
     */
    public function toArray()
    {
        $properties = $this->populatableProperties();
        $output = [];

        foreach ($properties as $property) {
            // Make sure that property is not unset
            if ( ! isset($this->$property)) {
                continue;
            }

            // Ensure to obtain value via evt. getter method
            $output[$property] = $this->__get($property);
        }

        return $output;
    }

    /**
     * {@inheritdoc}
     *
     * @throws Utils\Exceptions\JsonEncoding
     * @throws ReflectionException
     */
    public function toJson($options = 0)
    {
        return Json::encode($this->jsonSerialize(), $options);
    }

    /**
     * {@inheritdoc}
     *
     * @throws ReflectionException
     */
    public function jsonSerialize()
    {
        return array_map(function($value){

            if($value instanceof JsonSerializable){
                return $value->jsonSerialize();
            } else if($value instanceof Arrayable){
                return $value->toArray();
            }

            return $value;
        }, $this->toArray());
    }

    /**
     * Returns a string representation of this Data Transfer Object
     *
     * @return string
     *
     * @throws Utils\Exceptions\JsonEncoding
     * @throws ReflectionException
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Debug info
     *
     * @return array
     *
     * @throws ReflectionException
     */
    public function __debugInfo() : array
    {
        return $this->toArray();
    }

    /*****************************************************************
     * Array Access Methods
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Resolve and return the given value, for the given setter method
     *
     * @param string $setterMethodName The setter method to be invoked
     * @param mixed $value The value to be passed to the setter method
     *
     * @return mixed
     *
     * @throws BindingResolutionException
     * @throws ReflectionException
     */
    protected function resolveValue(string $setterMethodName, $value)
    {
        $reflection = new ReflectionClass($this);
        $method = $reflection->getMethod($setterMethodName);
        $parameter = $method->getParameters()[0];

        return $this->resolveParameter($parameter, $value);
    }

    /**
     * Resolve the given parameter; pass the given value to it
     *
     * @param ReflectionParameter $parameter The setter method's parameter reflection
     * @param mixed $value The value to be passed to the setter method
     *
     * @return mixed
     * @throws BindingResolutionException   a) If no concrete instance could be resolved from the IoC, or
     *                                      b) If the instance is not populatable and or the given value is not an
     *                                      array that can be passed to the populatable instance
     *                                      c) No service container is available
     */
    protected function resolveParameter(ReflectionParameter $parameter, $value)
    {
        // If there is no class for the given parameter
        // then some kind of primitive data has been provided
        // and thus we need only to return it.
        $paramClass = $parameter->getClass();
        if ( ! isset($paramClass)) {
            return $value;
        }

        // If the value corresponds to the given expected class,
        // then there is no need to resolve anything from the
        // IoC service container.
        $className = $paramClass->getName();
        if ($value instanceof $className) {
            return $value;
        }

        // Fail if no service container is available
        $container = $this->container();
        if ( ! isset($container)) {
            $message = sprintf(
                'No IoC Service Container is available, cannot resolve property "%s" of the type "%s"; do not know how to populate with "%s"',
                $parameter->getName(),
                $className,
                var_export($value, true)
            );
            throw new BindingResolutionException($message);
        }

        // Populate instance
        $instance = $container->make($className);
        return $this->resolveInstancePopulation($instance, $parameter, $value);
    }

    /**
     * Attempts to populate instance, if possible
     *
     * @param object $instance The instance that must be populated
     * @param ReflectionParameter $parameter Setter method's parameter reflection that requires the given instance
     * @param mixed $value The value to be passed to the setter method
     *
     * @return mixed
     * @throws BindingResolutionException If the instance is not populatable and or the given value is not an
     *                                      array that can be passed to the populatable instance
     */
    protected function resolveInstancePopulation($instance, ReflectionParameter $parameter, $value)
    {
        // Check if instance is populatable and if the given value
        // is an array.
        if ($instance instanceof Populatable && is_array($value)) {
            $instance->populate($value);

            return $instance;
        }

        // If we reach this part, then we are simply going to fail.
        // It is NOT safe to continue and make assumptions on how
        // we can populate the given instance. For this reason, we
        // just throw an exception
        $message = sprintf(
            'Unable to resolve dependency for property "%s" of the type "%s"; do not know how to populate with "%s"',
            $parameter->getName(),
            $parameter->getClass()->getName(),
            var_export($value, true)
        );

        throw new BindingResolutionException($message);
    }
}
