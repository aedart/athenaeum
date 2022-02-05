<?php

namespace Aedart\Dto\Partials;

use Aedart\Contracts\Utils\Populatable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\App;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use ReflectionType;
use ReflectionUnionType;
use Throwable;

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
            $types = $type->getTypes();

            $allAreBuiltIn = true;
            foreach ($types as $t){
                if (!$t->isBuiltin()) {
                    $allAreBuiltIn = false;
                    break;
                }
            }

            // Return value if all union types are builtin
            if ($allAreBuiltIn) {
                return $value;
            }
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
     * Builds the given class and populates it
     *
     * @param string $class Class path to instantiate / resolve from IoC
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

        // Fail if no service container is available
        $container = $this->container();
        if (!isset($container)) {
            $message = sprintf(
                'No IoC Service Container is available, cannot resolve property "%s" of the type "%s"; do not know how to populate with "%s"',
                $name,
                $class,
                var_export($value, true)
            );
            throw new BindingResolutionException($message);
        }

        // Populate instance
        $instance = $container->make($class);
        return $this->resolveInstancePopulation($instance, $parameter, $value);
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
