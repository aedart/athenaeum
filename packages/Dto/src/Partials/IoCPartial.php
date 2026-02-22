<?php

namespace Aedart\Dto\Partials;

use Aedart\Contracts\Dto;
use Aedart\Contracts\Utils\Populatable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\App;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionType;
use ReflectionUnionType;
use Throwable;
use TypeError;

/**
 * IoC Partial
 *
 * Keeps track of the assigned (or default) Service Container
 * and offers utils for resolving dependencies for mutator
 * methods.
 *
 * This partial is intended for the Dto abstraction(s)
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Dto\Partials
 */
trait IoCPartial
{
    /**
     * IoC Service Container
     *
     * @var null|Container
     */
    private Container|null $ioc = null;

    /**
     * Returns the container that is responsible for
     * resolving dependency injection or eventual
     * nested object
     *
     * @return Container|null IoC service Container or null if none defined
     */
    public function container(): Container|null
    {
        if (!isset($this->ioc)) {
            $this->ioc = App::getFacadeApplication();
        }

        return $this->ioc;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Set the IoC Service Container
     *
     * @param Container|null $ioc [optional]
     *
     * @return self
     */
    protected function setContainer(Container|null $ioc = null): static
    {
        $this->ioc = $ioc;

        return $this;
    }

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
     * @throws Throwable
     */
    protected function resolveValue(string $setterMethodName, mixed $value): mixed
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
     *
     * @throws BindingResolutionException   a) If no concrete instance could be resolved from the IoC, or
     *                                      b) If the instance is not populatable and or the given value is not an
     *                                      array that can be passed to the populatable instance
     *                                      c) No service container is available
     * @throws Throwable
     */
    protected function resolveParameter(ReflectionParameter $parameter, mixed $value): mixed
    {
        $type = $parameter->getType();

        // When no type is available...
        if (!isset($type)) {
            return $value;
        }

        // When union type given...
        if ($type instanceof ReflectionUnionType) {
            return $this->resolveUnionTypeParameter($type, $value, $parameter->getName());
        }

        // When a reflection type
        if ($type instanceof ReflectionType && $type->isBuiltin()) {
            return $value;
        }

        // If the value corresponds to the given expected class,
        // then there is no need to resolve anything from the
        // IoC service container.
        $className = $type->getName();
        if ($value instanceof $className) {
            return $value;
        }

        // Finally, resolve the class instance and populate it
        return $this->resolveClassAndPopulate($className, $parameter, $value);
    }

    /**
     * Resolve union type parameter
     *
     * @param  ReflectionUnionType  $parameter The setter method's union type parameter reflection
     * @param  mixed  $value The value to be passed to the setter method
     * @param  string  $parameterName Name of parameter
     *
     * @return mixed
     *
     * @throws BindingResolutionException
     * @throws ReflectionException
     * @throws Throwable
     */
    protected function resolveUnionTypeParameter(ReflectionUnionType $parameter, mixed $value, string $parameterName): mixed
    {
        $unionTypes = $parameter->getTypes();
        $isScalar = is_scalar($value);

        // Note: the gettype return values are NOT comparable with the ReflectionUnionType::getName()!
        // But we can use this in case of arrays, objects... etc.
        $valueType = gettype($value);

        foreach ($unionTypes as $type) {
            $typeName = $type->getName();
            $isBuiltin = $type->isBuiltin();

            // Whenever a scalar type is given (int, float, string or bool) and the type
            // is considered builtin, we simply return the value.
            if ($isBuiltin && $isScalar) {
                return $value;
            }

            // When builtin type is an array and the value type is also an array,
            // to return it...
            if ($isBuiltin && $typeName === 'array' && $valueType === 'array') {
                return $value;
            }

            // In case that "null" is provided and it is allowed...
            if ($valueType === 'NULL' && $type->allowsNull()) {
                return $value;
            }

            // When an object is given that is an instance of the type, return it...
            if (!$isBuiltin && $valueType === 'object' && $value instanceof $typeName) {
                return $value;
            }

            // Lastly, when type is an object that can be populated and an array is given,
            // then we attempt to resolve the class type and populate it, if the populatable
            // instance accepts the keys from given array value...
            if (!$isBuiltin && $valueType === 'array') {
                $resolved = $this->attemptPopulateUserDefinedClass($typeName, $parameterName, $value);
                if (isset($resolved)) {
                    return $resolved;
                }
            }
        }

        // This means that everything else has failed, and we do not know how to handle the given type.
        $allowedTypes = implode('|', array_map(function (ReflectionNamedType $type) {
            return $type->getName();
        }, $unionTypes));

        throw new TypeError(sprintf(
            'Unable to set property $%s. %s expected, but was %s given.',
            $parameterName,
            $allowedTypes,
            var_export($value, true)
        ));
    }

    /**
     * Attempt to populate user-defined class, e.g. DTO or populatable instance
     *
     * @param  string  $type
     * @param  string  $parameter
     * @param  mixed  $value
     *
     * @return mixed
     *
     * @throws BindingResolutionException
     * @throws Throwable
     */
    protected function attemptPopulateUserDefinedClass(string $type, string $parameter, mixed $value): mixed
    {
        // Skip if type isn't a class
        if (!class_exists($type)) {
            return null;
        }

        // Obtain reflection class, but skip if it is a builtin class type
        $typeReflection = new ReflectionClass($type);
        if (!$typeReflection->isUserDefined()) {
            return null;
        }

        // EDGE-CASE: when multiple DTOs are allowed and array data is provided, then we must ensure
        // that we only attempt to populate the instance that matches all keys from given array value.
        // Otherwise, we could end up attempting to populating an incorrect DTO.
        // This is not a 100% guarantee. If two different DTOs accept the same properties, then the
        // first DTO that is type-hinted will be populated, even though the developer might have
        // intended the second one to be populated.
        if ($typeReflection->implementsInterface(Dto::class)) {
            /** @var Dto $instance */
            $instance = $this->resolveInstanceFromIoC($type, $parameter, $value);

            $populatable = $instance->populatableProperties();
            $keys = array_keys($value);

            if (count(array_intersect($keys, $populatable)) === count($keys)) {
                return $this->resolveInstancePopulation($instance, $parameter, $value);
            }

            // Abort here, otherwise we might attempt to populate an incorrect DTO
            return null;
        }

        // In case that it's not a DTO, yet still an object that is populatable, then attempt
        // to populate it.
        if ($typeReflection->implementsInterface(Populatable::class)) {
            return $this->resolveClassAndPopulate($type, $parameter, $value);
        }

        // Unable to populate - we do not know how to...
        return null;
    }

    /**
     * Builds the given class and populates it
     *
     * @param class-string $class Class path to instantiate / resolve from IoC
     * @param ReflectionParameter|string $parameter Name of property or property reflection
     * @param mixed $value The value to be passed to the setter method
     *
     * @return mixed
     *
     * @throws BindingResolutionException
     * @throws Throwable
     */
    protected function resolveClassAndPopulate(string $class, ReflectionParameter|string $parameter, mixed $value): mixed
    {
        // In some situations, the given value is already an instance of the
        // given class. If such, then there is no need to do anything.
        if ($value instanceof $class) {
            return $value;
        }

        $name = $parameter;
        if ($parameter instanceof ReflectionParameter) {
            $name = $parameter->getName();
        }

        // Resolve instance from service container and populate it
        $instance = $this->resolveInstanceFromIoC($class, $name, $value);

        return $this->resolveInstancePopulation($instance, $parameter, $value);
    }

    /**
     * Resolve instance from Service Container
     *
     * @param  class-string  $class
     * @param  string  $property
     * @param  mixed  $value
     *
     * @return mixed
     *
     * @throws BindingResolutionException
     */
    protected function resolveInstanceFromIoC(string $class, string $property, mixed $value): mixed
    {
        // Fail if no service container is available
        $container = $this->container();
        if (isset($container)) {
            return $container->make($class);
        }

        $message = sprintf(
            'No IoC Service Container is available, cannot resolve property "%s" of the type "%s"; do not know how to populate with "%s"',
            $property,
            $class,
            var_export($value, true)
        );

        throw new BindingResolutionException($message);
    }

    /**
     * Attempts to populate instance, if possible
     *
     * @param mixed $instance The instance that must be populated
     * @param ReflectionParameter|string $parameter Name of property or property reflection
     * @param mixed $value The value to be passed to the setter method
     *
     * @return Populatable
     * @throws BindingResolutionException If the instance is not populatable and or the given value is not an
     *                                    array that can be passed to the populatable instance
     * @throws Throwable
     */
    protected function resolveInstancePopulation(mixed $instance, ReflectionParameter|string $parameter, mixed $value): Populatable
    {
        // Check if instance is populatable and if the given value
        // is an array.
        if ($instance instanceof Populatable && is_array($value)) {
            return $instance->populate($value);
        }

        // If we reach this part, then we are simply going to fail.
        // It is NOT safe to continue and make assumptions on how
        // we can populate the given instance. For this reason, we
        // just throw an exception
        $name = $parameter;
        if ($parameter instanceof ReflectionParameter) {
            $name = $parameter->getName();
        }

        $message = sprintf(
            'Unable to resolve dependency for property "%s"; do not know how to populate with "%s"',
            $name,
            var_export($value, true)
        );

        throw new BindingResolutionException($message);
    }
}
